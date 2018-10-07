<?php

namespace App\Classes;

use App\Interfaces\View\ViewInterface;
use App\Interfaces\View\ViewSanitationInterface;

class View implements ViewInterface, ViewSanitationInterface
{
    const VIEW_FOLDER = "../../views";


    /**
     * Contains the location of the template. E.g. user/signup
     * @var string
     */
    private $templateName;

    private $data = [];

    /**
     * Construct a View that will create a view with template $templateName.
     * @param string $templateName Relative template name. See VIEW_FOLDER constant for location of view files.
     *                             No file extension is required, .php is assumed automatically.
     *                             If template is located in a folder, then $templateName should
     *                             be $folderName/$filename.
     */
    public function __construct(string $templateName)
    {
        $this->templateName = $templateName;
    }

    /**
     * @inheritdoc
     */
    public function render(): string
    {
        extract($this->data, EXTR_SKIP);
        ob_start();
        include(__DIR__ . DIRECTORY_SEPARATOR . View::VIEW_FOLDER . DIRECTORY_SEPARATOR . $this->templateName . '.php');
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    /**
     * @inheritdoc
     */
    public function setAttribute(string $key, $value): void
    {
        // Because `extract()` is run in render(),
        if ($key === "data") {
            throw new \InvalidArgumentException("Key must not equal `data`");
        }
        if ($key === "template") {
            throw new \InvalidArgumentException("Key must not equal `template'");
        }

        $this->data[$key] = $value;
    }

    /**
     * @inheritdoc
     */
    public function escape(string $input): string
    {
        return htmlspecialchars($input);
    }
}
