import Mqtt from "/site_dash/public/js/Mqtt.js";
const mqttClient = new Mqtt();

$(document).ready(() => {

    // Função para obter vídeos com base na filial selecionada
    function getVideosByPriority(filial) {
        const formData = new FormData();
        formData.set('filial', filial);
        return fetch(`/site_dash/configs/Router.php?action=getByPriority`, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log("Dados recebidos (dados por prioridade):", data);
                return data;
            })
            .catch((e) => {
                console.log(e);
                return [];
            });
    }

    //Função para renderizar os vídeos no grid
    let videoList = [];
    function renderVideos(videos) {
        videoList = videos;
        const container = $("#videoGrid");
        container.empty();
        const numVideos = videos.length;
        const numInputs = 5 - numVideos;
        const defaultImage = "/site_dash/public/tumb/default.png";
        videos.forEach(video => {
            const title = video.title || "Título não disponível";
            const thumbnail = video.linkImage && video.linkImage.trim() !== ""
                ? video.linkImage
                : defaultImage;
            const videoElement = `
            <div class="videoContainer rounded-5" data-id="${video.id}">
                <img src="${thumbnail}" alt="Thumbnail do vídeo" class="thumbnailImage rounded-4">
                <div class="overlay-title position-absolute bottom-0 start-0 text-center white-text p-2">
                    <h5 class="card-title truncated-title" data-bs-toggle="tooltip" data-bs-placement="bottom" title="${title}">
                        ${title}
                    </h5>
                </div>
                <button class="deleteButton" data-id="${video.id}">&times;</button>
                <button class="playButton" data-id="${video.id}"><i class="fas fa-play"></i></button>
            </div>`;
            container.append(videoElement);
        });
        $('[data-bs-toggle="tooltip"]').tooltip();
        for (let i = 0; i < numInputs; i++) {
            const uploadButton = `
            <div class="videoContainer rounded-4 uploadButton">
                <button type="button" class="btn buttonVideo" data-bs-toggle="modal" data-bs-target="#videoModal">
                    <span class="addIcon">+</span>
                </button>
            </div>`;
            container.append(uploadButton);
        }
    }


    // Limpar o conteúdo do modal ao fechá-lo
    $("#videoPlayerModal").on("hidden.bs.modal", function () {
        $(this).find(".modal-body").empty();
    });
    $("#videoModal").on("hidden.bs.modal", function () {
        $(this).find("input[type='file']").val("");
        $(this).find(".invalid-feedback").hide();
    })

    // Evento para abrir o modal do player com o vídeo correspondente
    $(document).on("click", ".playButton", function () {
        const videoId = $(this).data("id");
        const video = videoList.find(v => v.id === videoId);
        if (video) {
            const videoPlayerModal = $("#videoPlayerModal");
            const videoContent = `
                <video controls autoplay class="w-100 rounded-4">
                    <source src="${video.link}" type="video/mp4">
                </video>`;
            videoPlayerModal.find(".modal-body").html(videoContent);
            videoPlayerModal.modal("show");
        } else {
            console.log("Vídeo não encontrado para o ID:", videoId);
        }
    });

    // Evento para excluir o vídeo
    $('#videoGrid').on('click', '.deleteButton', function () {
        const videoId = $(this).data('id');
        console.log("ID do vídeo:", videoId);
        Swal.fire({
            title: 'Você tem certeza?',
            text: 'Esta ação excluirá o vídeo permanentemente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('id', videoId);
                fetch('/site_dash/configs/Router.php?action=deletePathVideo', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            mqttClient.publishMessage('Multi/UpdateVideo', 'update');
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso!',
                                text: result.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                fetchVideos();
                                $('#videoModal').modal('hide');
                                $("#createForm")[0].reset();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro!',
                                text: result.message
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: 'Erro ao excluir o vídeo. Tente novamente.'
                        });
                        console.error('Erro:', error);
                    });
            }
        });
    });

    // Função para buscar os vídeos atualizados
    function fetchVideos() {
        const selectedFilial = $('#filial').val();
        if (selectedFilial) {
            getVideosByPriority(selectedFilial).then(videos => {
                renderVideos(videos);
            });
        }
    }

    // Evento de select para a filial
    $('#filial').change(fetchVideos);

    // Evento para enviar o submit
    $("#createForm").submit(function (event) {
        event.preventDefault();
        const videoInput = $("#video")[0];
        if (!videoInput.files.length) {
            Swal.fire({
                icon: 'warning',
                title: 'Campo obrigatório!',
                text: 'Por favor, selecione um vídeo para enviar.',
            });
            return;
        }
        Swal.fire({
            title: 'Enviando...',
            text: 'Aguarde enquanto o vídeo é enviado.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        const startTime = Date.now();
        const formData = new FormData(this);
        formData.append("location", $("#filial").val());
        fetch("/site_dash/configs/Router.php?action=videoUpload", {
            method: "POST",
            body: formData,
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro na requisição: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const elapsedTime = Date.now() - startTime;
                const remainingTime = Math.max(0, 1200 - elapsedTime);
                setTimeout(() => {
                    if (data.status === "success") {
                        mqttClient.publishMessage('Multi/UpdateVideo', 'update');
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            fetchVideos();
                            $('#videoModal').modal('hide');
                            $("#createForm")[0].reset();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: data.message,
                        });
                    }
                }, remainingTime);
            })
            .catch(error => {
                const elapsedTime = Date.now() - startTime;
                const remainingTime = Math.max(0, 1200 - elapsedTime);

                setTimeout(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: error.message || 'Contate o time de desenvolvimento.',
                    });
                }, remainingTime);
            });
    });

    // Função chamada ao mover vídeos no sortable
    function updateVideoOrder() {
        const orderedVideos = $('#videoGrid .videoContainer').map(function () {
            return $(this).data('id');
        }).get();
        const formData = new FormData();
        formData.set('orderedVideos', JSON.stringify(orderedVideos));
        formData.set('filial', $('#filial').val());
        fetch('/site_dash/configs/Router.php?action=updateVideoOrder', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    console.log('Ordem dos vídeos atualizada no servidor.');
                    reorderDOM(orderedVideos);
                    mqttClient.publishMessage('Multi/UpdateVideo', 'update')
                } else {
                    console.error('Erro ao atualizar ordem dos vídeos.');
                }
            })
            .catch(() => console.error('Erro ao fazer requisição para atualizar ordem.'));
    }

    // Evento de select para a filial
    function reorderDOM(orderedVideos) {
        const container = $('#videoGrid');
        const videoElements = {};
        container.children('.videoContainer').each(function () {
            const id = $(this).data('id');
            videoElements[id] = this;
        });
        container.empty();
        orderedVideos.forEach(id => {
            if (videoElements[id]) {
                container.append(videoElements[id]);
            }
        });
        const numInputs = 5 - orderedVideos.length;
        for (let i = 0; i < numInputs; i++) {
            const uploadButton = `
            <div class="videoContainer rounded uploadButton">
                <button type="button" class="btn buttonVideo" data-bs-toggle="modal" data-bs-target="#videoModal">
                    <span class="addIcon">+</span>
                </button>
            </div>`;
            container.append(uploadButton);
        }
    }

    // Inicializando o Sortable
    new Sortable(document.getElementById('videoGrid'), {
        animation: 150,
        ghostClass: 'sortable-ghost',
        handle: '.videoContainer',
        draggable: '.videoContainer:not(.uploadButton)',
        direction: 'horizontal',
        onEnd: updateVideoOrder
    });

    // Carregar vídeos inicialmente
    fetchVideos();
});