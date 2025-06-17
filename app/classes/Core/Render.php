<?php

namespace Core;

class Render
{
    protected string $layout = './app/views/layouts/main.layout.php';
    protected string $viewBasePath = './app/views/';

    public function setLayout(string $layoutName): void
    {
        $this->layout = $this->viewBasePath . 'layouts/' . $layoutName . '.layout.php';
    }

    public function render(string $path, array $data = [], bool $useLayout = true): void
    {
        $viewFile = $this->viewBasePath . str_replace('.', '/', $path) . '.view.php';

        if (!file_exists($viewFile)) {
            echo "View file not found: " . $viewFile;
            exit;
        }

        if (!empty($data)) {
            extract($data);
        }

        if ($useLayout) {
            ob_start();
            require $viewFile;
            $contents = ob_get_clean();
            require $this->layout;
        } else {
            require $viewFile;
        }
    }
}
