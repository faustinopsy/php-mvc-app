<?php
namespace App\Core;

class View {
    private $templatePath;
    private $partialsPath;

    public function __construct($templatePath = '../Views/templates/', $partialsPath = '../Views/templates/partials/') {
        $this->templatePath = $templatePath;
        $this->partialsPath = $partialsPath;
    }

    public static function render($view, $data = []) {
        extract($data);

        include __DIR__. '/../Views/templates/partials/header.php';

        include __DIR__. '/../Views/templates/' . $view . '.php';

        include __DIR__. '/../Views/templates/partials/footer.php';
    }

    public static function renderError($errorView) {
        include __DIR__. '/../Views/errors/' . $errorView . '.php';
    }
}