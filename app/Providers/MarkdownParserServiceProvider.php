<?php


namespace App\Providers;


use App\Providers\Markdown\Extension\CenterExtension;
use App\Providers\Markdown\Inline\Element\BlankLink;
use App\Providers\Markdown\Inline\Element\Center;
use App\Providers\Markdown\Inline\Parser\CenterParser;
use App\Providers\Markdown\Inline\Parser\TwitterHandleParser;
use App\Providers\Markdown\Inline\Renderer\CenterRenderer;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Inline\Renderer\LinkRenderer;

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


//            $environment->addInlineRenderer(Center::class, new CenterRenderer());
//            $environment->addInlineRenderer(BlankLink::class, new LinkRenderer());


            $environment->addExtension(new CenterExtension());
//            $environment->addInlineParser(new TwitterHandleParser());

            $converter = new CommonMarkConverter([
                'html_input' => 'escape',
                'allow_unsafe_links' => false,
                'max_nesting_level' => '5'
            ], $environment);

            return $converter;
        });
    }
}