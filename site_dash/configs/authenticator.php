<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/site_dash/configs/SessionValidator.php");
$sessionValidator = new SessionValidator();
$sessionValidator->sessionValidate();
