<?php

use App\Helpers\Flash;
use App\Helpers\BreadCrumb;
use App\Builders\PaginationBuilder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 *  Resolve o resultado de uma chave de cache e retorna seu valor. Caso chamado
 * sem nenhum argumento, retorna uma instancia de \App\Helpers\CacheManager.
 * @param  string   $key   Chave de cache
 * @param  string   $ttl   Tempo de duração do cache. Ver guia de formatos
 * relativos em http://php.net/manual/pt_BR/datetime.formats.relative.php
 * @param  callable $value Valor a ser criado cache
 * @param  array    $tags  Marcações para a chave de cache
 * @return mixed
 */
function cache_manager()
{
    $args = func_get_args();
    $cacheManager = app()->make(\App\Helpers\CacheManager::class);
    if (empty($args)) {
        return $cacheManager;
    }
    return $cacheManager->remember(...$args);
}

/**
 * Return wether application cache is enabled.
 * @return boolean Application cache is enabled.
 */
function application_cache_is_enabled()
{
    return config('cache.enable_application_cache');
}

/**
 * All files in this folder will be included in the application.
 */

/**
 * Separar os ítens de uma array por vírgula.
 *
 * @param array $array Array que será dividida.
 * @return string
 */
function separe_by_comma($array, $lastGlue = ', ')
{
    if (sizeof($array) != 1) {
        $last = array_pop($array);
        $glued = implode(', ', $array);
        return $glued . $lastGlue . $last;
    }

    return implode(', ', $array);
}

/**
 * Separar os ítens de uma array por vírgula.
 *
 * @param Date $date Date to format.
 * @param string $format Format.
 * @param string $from_format Origin format.
 * @return string
 */
function format_date($date, $format = null, $from_format = null)
{
    if ($date == null) {
        return null;
    }

    if ($format == null) {
        $format = __('dates.php.dateTimeFormat');
    }

    if ($date instanceof \Carbon\Carbon) {
        return $date->format($format);
    }

    if ($from_format != null) {
        $date = \Carbon\Carbon::createFromFormat($from_format, $date);
    } else {
        $date = \Carbon\Carbon::parse($date);
    }

    return $date->format($format);
}

/**
 * Retorna mensagens padrões dentro do arquivo 'flash' de tradução.
 *
 *  A chave será buscada em flash.common.CHAVE_INSERIDA. Caso não seja
 * encontrado nada, a chave passada por parâmetro é retornada.
 *
 * @param string $key Chave do caminho para acessar.
 * @return string
 */
function get_common_message_translate($key)
{
    $path = "flash.common.{$key}";
    $translated = __($path);
    if ($path === $translated) {
        return $key;
    }
    return $translated;
}


/**
 * Retorna mensagens do arquivo 'flash' de tradução.
 *
 *  A chave será buscada em flash.CHAVE_INSERIDA. Caso não seja
 * encontrado nada, tentará retornar a mensagem padrão. Caso não encontre
 * também, será retornada a chave completa.
 *
 * @param mixed $key Chave do caminho para acessar. Pode ser uma string ou
 * uma array com as seguintes chaves: 'domain' e 'message_path'.
 * @param string $default Mensagem padrão caso não encontre a chave.
 * @return string
 */
function find_message($key, $default = null)
{
    $separated_key = $key;
    if (!is_array($separated_key)) {
        $exploded = explode('.', $separated_key);
        $separated_key = [];
        $separated_key['domain'] = head($exploded);
        $separated_key['message_path'] = implode('.', array_slice($exploded, 1));
    }

    $message_path = implode('.', Arr::flatten($separated_key));
    $message_path = "flash.{$message_path}";

    $translated = __($message_path);

    if ($translated === $message_path) {
        if ($default != null) {
            return $default;
        }
        $common = get_common_message_translate($separated_key['message_path']);
        if ($common === $separated_key['message_path']) {
            return $message_path;
        }
        return $common;
    }

    return $translated;
}

/**
 * Alias para 'find_message'. Retorna mensagens do arquivo 'flash' de tradução.
 *
 *  A chave será buscada em flash.CHAVE_INSERIDA. Caso não seja
 * encontrado nada, tentará retornar a mensagem padrão. Caso não encontre
 * também, será retornada a chave completa.
 *
 * @param mixed $key Chave do caminho para acessar. Pode ser uma string ou
 * uma array com as seguintes chaves: 'domain' e 'message_path'.
 * @param string $default Mensagem padrão caso não encontre a chave.
 * @return string
 */
function _m($key, $default = null)
{
    return find_message($key, $default);
}


/**
 *  Caso exista algum erro para o campo passado como parâmetro, é retornada
 * a classe 'form-control-danger'.
 *
 * @param string $field Nome do campo do formulário
 * @return string
 */
function has_error($field, $output = null)
{
    $errors = \Session::get('errors');
    if (empty($errors)) {
        return '';
    }

    $output = ($output != null) ? $output : 'has-danger';

    return $errors->has($field) ? $output : '';
}

/**
 *  Caso exista algum erro para o campo passado como parâmetro, é retornada
 * a classe 'form-control-danger'.
 *
 * @param string $field Nome do campo do formulário
 * @return string
 */
function has_error_class($field)
{
    $errors = \Session::get('errors');
    if (empty($errors)) {
        return '';
    }

    return $errors->has($field) ? 'is-invalid' : '';
}

/**
 *  Aplica uma máscara à uma string.
 *
 * @param string $value Valor a ser mascarado
 * @param string $mask Máscara
 * @param string $mask_character Caractere que representará os valores preenchíveis
 * @return string
 */
function mask($value, $mask, $mask_character = '#')
{
    $value = str_replace(" ", "", $value);
    for ($i = 0; $i < strlen($value); $i++) {
        $mask[strpos($mask, $mask_character)] = $value[$i];
    }

    return $mask;
}

/**
 * Retorna o valor de moeda formatado com prefixo
 *
 * @param $value
 * @param string $moneyFormat
 * @return string
 */
function money($value, $moneyFormat = 'BRL')
{
    return MoneyHelper::money($value, $moneyFormat);
}

/**
 * Retorna apenas o valor com um prefixo
 *
 * @param $value
 * @param string $prefix
 * @return string
 */

function money_prefix($value, $prefix = 'R$')
{
    return \BitblueAdmin\Helpers\MoneyHelper::moneyPrefix($value, $prefix);
}

/**
 * Retorna se o prefixo da rota atual é igual ao parametro passado
 * ex: users.index, users.create.
 * prefixo: users
 *
 * @param string $routeName Nome da Rota
 * @return boolean
 */
function is_current_route($route_name, $strict = false)
{
    $route_name_prefix = implode('.', explode('.', $route_name, -1));
    $route_compare_prefix = implode('.', explode('.', Route::currentRouteName(), -1));

    $has_same_prefix = ($route_compare_prefix !== '' && $route_compare_prefix === $route_name_prefix);
    $is_actual_route = ($route_name === Route::currentRouteName());

    if ($strict) {
        return $is_actual_route;
    }

    return ($has_same_prefix || $is_actual_route);
}

/**
 *  Caso o prefixo da rota atual seja igual ao parâmetro passado, é retornada
 * a classe 'active'.
 *
 * @param string|array $field Nome do campo do formulário
 * @return string
 */
function is_active($routeName, $output = 'active', $strict = false)
{
    if (is_array($routeName)) {
        foreach ($routeName as $route) {
            if (is_current_route($route, $strict)) {
                return $output;
            }
        }

        return '';
    }

    return (is_current_route($routeName, $strict)) ? $output : '';
}

function is_active_route(array $routes, $output = 'active')
{
    $current_route_name = Route::currentRouteName();
    $is_active = in_array($current_route_name, $routes);
    return ($is_active) ? $output : '';
}

function user_has_role_name($name)
{
    $user = current_user();

    return $user->getRoleNames()->contains($name);
}

/**
 * Checar se tag "selected" deve ser "selected".
 *
 * @param $value Array que será dividida.
 * @param $array Array que será dividida.
 * @return string
 */
function selected($value, $compared)
{
    return $value == $compared ? 'selected' : '';
}

function checked($value, $compared)
{
    return $value == $compared ? 'checked' : '';
}

/**
 * Retorna uma instância do builder de paginação.
 *
 * @return \App\Builders\PaginationBuilder
 */
function pagination()
{
    return new PaginationBuilder();
}

/**
 * Retorna uma instância do helper BreadCrumb
 *
 * @return \App\Suppport\BreadCrumb
 */
function breadcrumb()
{
    return new BreadCrumb();
}

/**
 * Retorna uma instância do helper Flash
 *
 * @return \App\Helpers\Flash
 */
function flash()
{
    return new Flash();
}

/**
 * Retorna uma instância do usuário corrente.
 *
 * @return \App\Models\User
 */
function current_user()
{
    return auth()->user();
}

/**
 * Remover tudo que não for número ou vírgula e substituir vírgula por ponto.
 * Retorna o valor formatado para o formato americano trocando pontos e vírgulas.
 * @param $value
 * @return string
 */
function remove_mask_money($value, $fromMoneyFormat = 'BRL')
{
    return App\Helpers\MoneyHelper::removeMaskMoney($value, $fromMoneyFormat);
}

function parse_decimal($value)
{
    return number_format($value, 2, '.', '');
}

function decimal_to_currency($value)
{
    return __('labels.common.currency') . ' ' . number_format($value, 2, ',', '.');
}

function format_to_decimal($value)
{
    return number_format($value, 2, ',', '.');
}

/**
 * Aplica argumentos em parâmetros de uma string
 *
 * @return string
 */
function apply_params(string $string, array $params, $before = ':', $after = '')
{
    $regex = '/' . $before . '[a-z_]+' . $after . '/';
    return preg_replace_array($regex, $params, $string);
}

/**
 * Retorna se a aplicação está em produção.
 *
 * @return bool
 */
function in_production()
{
    $actualEnv = app()->environment();
    return (Str::startsWith($actualEnv, 'prod'));
}


function validation_message($validation, $attribute)
{
    $string = __('validation.' . $validation);
    $searchReplace = [':attribute' => __('validation.attributes.' . $attribute)];
    return apply_params($string, $searchReplace);
}

function storage_public($path = '')
{
    return storage_path('app/public/' . $path);
}

/**
 * Retorna o timestamp atual em milisegundos
 *
 * @return int
 */
function milliseconds()
{
    $microTime = explode(' ', microtime());
    return ((int)$microTime[1]) * 1000 + ((int)round($microTime[0] * 1000));
}

/**
 * Retorna o tempo, em milisegundos, que um método é executado.
 *
 * @param callable $function Método a ser estressado
 * @param int $times Quatidade de vezes que o método será executado
 * @param bool $dumpAndDie Encerrar a aplicação com o resultado do teste
 * @return int tempo de execução
 */
function stress(callable $function, int $times = 1000, bool $dumpAndDie = true)
{
    $init_time = milliseconds();
    for ($i = 0; $i < $times; $i++) {
        $function();
    }
    $result_time = milliseconds() - $init_time;

    if ($dumpAndDie) {
        dd($result_time);
    }

    return $result_time;
}

/**
 * Retorna a mensagem com a coluna específica para ordenação em tabelas
 *
 * @return string
 */

function get_sort_message($column)
{
    return __('labels.common.sort', ['column' => __('headings.common.' . $column)]);
}

if (!function_exists('cached_include')) {
    /**
     * Mimics the blade include function but caches the rendered for $time
     * minutes in key 'cache:partials:<view_name>:<context>_<$cache_key>'
     * in order to avoid conflicts and to be able to flush the view using
     * patterns.
     *     Ex: Cache::clear('cache:partials:myview_*');
     *
     * @param  string $view The name of the view that are going to be included.
     * @param  array $vars Variables that are being passed to the view.
     * @param  integer $time The amount of minutes that the result of the view is going to be stored.
     *
     * @return string             Html code of the included view
     */
    function cached_include($view, $vars = null, $time = 60)
    {
        $renderedView = function () use ($view, $vars) {
            return view(
                $view,
                is_array($vars)
                    ? $vars
                    : Arr::except(get_defined_vars(), ['__data', '__path'])
            )->render();
        };

        if (config('cache.enable_application_cache')) {
            $cacheKey = $view . ':' . md5(serialize($vars));
            return Cache::remember($cacheKey, $time, $renderedView);
        }

        return $renderedView();
    }
}

/**
 * Retorna a string de um valor booleano.
 * @param $value
 * @return string
 */
function strbool($value)
{
    return $value ? 'true' : 'false';
}

/**
 * Caso a condiçãoi seja suprida, retorna uma saída, caso contrário, null.
 * @param $condition
 * @param $output
 * @return mixed
 */
function output_if($condition, $output)
{
    return $condition ? $output : null;
}

/**
 * Retrieve a value based on a given condition.
 *
 * @param  bool $condition
 * @param  mixed $value
 * @param  mixed $default
 * @return mixed
 */
function when($condition, $value, $default = null)
{
    if ($condition) {
        return value($value);
    }

    return func_num_args() === 3
        ? value($default)
        : null;
}

/**
 * Validate if param is a valid URL;
 * @param  string $uil
 * @return boolean
 */
function is_valid_url(string $url)
{
    return (bool) filter_var($url, FILTER_VALIDATE_URL);
}

/**
 * Get current version of application
 * @return string
 */
function app_version()
{
    return \BitblueAdmin\Helpers\ChangeLogHelper::getCurrentVersion();
}

function diff_between_value_and_paid($value, $paid)
{
    return ($value > 0) ? (($paid * 100) / $value) - 100 : 0;
}
