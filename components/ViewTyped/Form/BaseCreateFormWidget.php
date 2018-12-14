<?php
namespace app\components\ViewTyped\Form;

use yii\base\InvalidCallException;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

class BaseCreateFormWidget extends ActiveForm
{
    /**
     * @var ActiveField[] the ActiveField objects that are currently active
     */
    private $_fields = [];

    protected $content;

    protected $footer = null;

    protected $defaultLayoutPath        = '@app/views/layouts/default/common/forms/base_form.php';
    protected $defaultFooterLayoutPath  = '@app/views/layouts/default/common/pages/_submit_buttons.php';
    protected $cancelUrl = '#';

    /**
     * Initializes the widget.
     * This renders the form open tag.
     */
    public function init()
    {
        parent::init();

        $this->setCancelUrl(Url::toRoute(\Yii::$app->controller->id .'/index'));
    }

    /**
     * Runs the widget.
     * This registers the necessary JavaScript code and renders the form open and close tags.
     * @throws InvalidCallException if `beginField()` and `endField()` calls are not matching.
     */
    public function run()
    {

        if (!empty($this->_fields)) {
            throw new InvalidCallException('Each beginField() should have a matching endField() call.');
        }
        $layout = $this->getLayout();
        $this->content = ob_get_clean();

        echo Html::beginForm($this->action, $this->method, $this->options);


        $renderable = preg_replace_callback('/{\\w+}/', function ($matches) {
            $section = $this->renderSection($matches[0]);
            return $section === false ? $matches[0] : $section;
        }, $layout);

        echo $renderable;
        if ($this->enableClientScript) {
            $this->registerClientScript();
        }

        echo Html::endForm();
    }

    /**
     * Renders a section of the specified name.
     * If the named section is not supported, false will be returned.
     * @param string $name the section name, e.g., `{summary}`, `{items}`.
     * @return string|bool the rendering result of the section, or false if the named section is not supported.
     */
    public function renderSection($name)
    {

        switch ($name) {
            case '{content}':
                return $this->renderContent();
            case '{footer}':
                return $this->renderFooter();
            default:
                return false;
        }
    }

    public function renderContent()
    {
        return $this->content;
    }

    public function renderFooter()
    {
        if (isset($this->footer)){
            return $this->footer;
        }
        return $this->render($this->defaultFooterLayoutPath,['cancelUrl' => $this->cancelUrl]);
    }

    public function getViewPath()
    {
        return '@app/views/layouts/default/common/forms';
    }

    public function getLayout()
    {
        return $this->render($this->defaultLayoutPath);
    }

    /**
     * @param null $footer
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
    }

    /**
     * @param string $cancelUrl
     */
    public function setCancelUrl(string $cancelUrl)
    {
        $this->cancelUrl = $cancelUrl;
    }
}