<?php

namespace App\Extensions\Markdown\Providers;

use App\Extensions\Markdown\Extension\CenterExtension;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use App\Extensions\Markdown\Inline\Renderer\LinkRenderer;
use League\CommonMark\Inline\Element\Link;

class MarkdownParserServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->compiler()->directive('markconverter', function ($expression) {
            return "<?php echo markconverter($expression); ?>";
        });
    }

    /**
     * @return BladeCompiler
     */
    protected function compiler()
    {
        return app('view')->getEngineResolver()->resolve('blade')->getCompiler();
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton('markconverter', function () {

            $environment = Environment::createCommonMarkEnvironment();

            $environment->addInlineRenderer(Link::class, new LinkRenderer(), 1);

            $environment->addExtension(new CenterExtension());

            $converter = new CommonMarkConverter([
                'html_input' => 'escape',
                'allow_unsafe_links' => false,
                'max_nesting_level' => '5'
            ], $environment);

            return $converter;
        });
    }
}
