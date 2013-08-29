<?php
/**
 * View:
 *
 * - extends Twig
 * - load layout template
 *
 */
namespace Sblog\Lib;

class View extends \Slim\Views\Twig
{
    protected $layout;

    /**
     *
     * @param string|false $layout
     */
    public function __construct($layout=null)
    {
        if ($layout === null) $layout = 'layout/default.html';
        $this->layout = $layout;
        parent::__construct();
    }

    /**
     *
     * @param string $template template name
     * @return string rendered template
     */
    public function render($template)
    {
        $env = \Slim\Environment::getInstance();
        $this->setData('_base', $env['SCRIPT_NAME']);
        $data = $this->getData();
        if (isset($data['_layout'])) $layout = $data['_layout'];
        else $layout = $this->layout;
        $content = parent::render($template);
        if ($layout !== false) {
            $this->setData($data);
            $this->setData('content', $content);
            $content = parent::render($layout);
        }
        return $content;
    }
}


// TODO delete following lines

/*
class View extends \Sblog\Lib\Core
{
    public function __construct($app)
    {
        \Slim\Extras\Views\Twig::$twigOptions = array (
                'charset' => 'utf-8',
                'cache' => TEMPLATES_CACHE_DIR,
                'auto_reload' => true,
                'strict_variables' => false,
                'autoescape' => true
        );

        $app->view ( new \Slim\Extras\Views\Twig () );
    }
}
*/

/*
 // Slim\Extras : Twig options
\Slim\Extras\Views\Twig::$twigOptions = array(
        'charset' => 'utf-8',
        'cache' => TEMPLATES_CACHE_DIR,
        'auto_reload' => true,
        'strict_variables' => false,
        'autoescape' => true
);
$app->view(new \Slim\Extras\Views\Twig());
*/
