import Mqtt from "/site_dash/public/js/Mqtt.js";
const mqttClient = new Mqtt();

// Definindo um objeto de tópicos e ações associadas
mqttClient.on('message', (topic, message) => {
    const topicsActions = {
        'Multi/Controlar': updateVideo,
        'Multi/UpdateVideo': updateVideo,
        'Multi/CreateVideo': updateVideo,
        'Multi/DeleteVideo': updateVideo
    };
    if (topicsActions[topic]) {
        topicsActions[topic]();
    }
});

// Função para atualizar os vídeos
async function updateVideo() {
    const filial = document.getElementById('filial').value;
    try {
        const response = await fetch("/site_dash/configs/Router.php?action=videoView", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ location: filial })
        });
        const videoAntigo = await response.json();
        if (videoAntigo && videoAntigo.videos) {
            loadVideo(videoAntigo.videos);
        } else {
            console.log("Nenhum vídeo encontrado na resposta.");
        }
    } catch (error) {
        console.log("Erro ao atualizar lista de vídeos", error);
    }
}

// Função para carregar os vídeos com atraso e mostrar uma mensagem antes da reprodução
async function loadVideo(videos) {
    const filial = document.getElementById('filial').value;
    if (!filial) {
        Swal.fire({
            icon: 'warning',
            title: 'Atenção!',
            text: 'Escolha uma filial antes de carregar os vídeos!',
        });
        return;
    }
    try {
        if (videos && videos.length > 0) {
            const videoPlayer = document.getElementById('videoPlayer');
            let currentIndex = 0;
            const preloadVideo = (src) => {
                return new Promise((resolve, reject) => {
                    const tempVideo = document.createElement('video');
                    tempVideo.src = src;
                    tempVideo.preload = 'auto';
                    const startPreloadTime = performance.now();
                    tempVideo.onloadeddata = () => {
                        const endPreloadTime = performance.now();
                        const preloadDuration = (endPreloadTime - startPreloadTime).toFixed(2);
                        console.log(`Tempo de pré-carregamento do vídeo: ${preloadDuration} ms`);
                        resolve();
                    };

                    tempVideo.onerror = reject;
                });
            };
            Swal.fire({
                title: 'Aguarde...',
                text: 'Carregando os vídeos. O vídeo começará em breve!',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'swal-popup',
                    timerProgressBar: 'swal-progress-bar'
                }
            });
            await preloadVideo(videos[currentIndex]);
            Swal.fire({
                title: 'Pronto!',
                text: 'O vídeo está pronto para ser exibido.',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                playNextVideo();
            });
            const playNextVideo = () => {
                videoPlayer.src = videos[currentIndex];
                videoPlayer.load();
                const startPlayTime = performance.now();
                videoPlayer.play();
                videoPlayer.onplay = () => {
                    const endPlayTime = performance.now();
                    const playDuration = (endPlayTime - startPlayTime).toFixed(2);
                    console.log(`Tempo real de reprodução do vídeo: ${playDuration} ms`);
                };
                currentIndex = (currentIndex + 1) % videos.length;
            };
            videoPlayer.onended = playNextVideo;
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Nenhum vídeo encontrado',
                text: 'Nenhum vídeo foi encontrado para esta filial.',
            });
        }
    } catch (error) {
        console.error("Erro ao carregar os vídeos!", error);
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'Erro ao buscar os vídeos. Tente novamente mais tarde.',
        });
    }
}

$(document).ready(() => {
    document.getElementById('filial').addEventListener('change', updateVideo);
});