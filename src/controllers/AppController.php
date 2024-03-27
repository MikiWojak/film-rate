<?php

class AppController {
    private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }

    // @NOTE Initially protected
    public function render(string $template = null, array $variables = [])
    {
        // @NOTE Initially .php
        $templatePath = 'public/views/'. $template.'.html';
        // @TODO 404 page
        $output = 'File not found';
                
        if(file_exists($templatePath)){
            // Extract variables
            extract($variables);
            
            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        
        print $output;
    }
}
