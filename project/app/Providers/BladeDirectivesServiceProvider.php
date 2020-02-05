<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BladeDirectivesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::directive(
            'errorblock',
            function ($expression) {
                eval("\$params = [$expression];");
                $params[1] = data_get($params, '1', 'false');
                list($field, $required) = $params;

                $directive = "<?php ";
                $directive .= " \$field = '{$field}';";
                $directive .= " \$required = {$required};";
                $directive .= " \$variables = Arr::except(get_defined_vars(), ['__data', '__path']);";
                $directive .= " \$rendered = \$__env->make('shared.error_block', \$variables)->render();";
                $directive .= " echo \$rendered; ?>";

                return $directive;
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
