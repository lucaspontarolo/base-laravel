<?php

return [
    'common' => [
        'required_fields' => 'Todos os campos com (*) são de preenchimento obrigatório.',
        'password_caracter' => 'Senha deve ter no mínimo 6 caracteres.',
        'empty_table' => '* Nenhum registro encontrado *'
    ],

    'cloud-message' => [
        'ttl_in_seconds' => 'Tempo de vida da mensagem em segundos.',
        'redirect_url_help' => 'Utilizar a URL relativa, sem o domínio do site. Ex: categoria/slug_url',
    ],

    'auth' => [
        'account_recover' => 'Informe seu email e enviaremos um e-mail com instruções para redefinir sua senha.',
    ],

    'errors' => [
        'titles' => [
            'page-not-found' => 'Página não encontrada!',
            'access-forbidden' => 'Acesso restrito',
            'internal-server-error' => 'Erro interno do servidor :(',
        ],
        'messages' => [
            'link-is-broken' => 'O link está quebrado ou a página foi movida.',
            'access-forbidden' => 'Desculpe, mas você não tem permissão para acessar esta página.',
            'internal-server-error' => 'Por favor, reporte este erro para um administrador.',
        ],
    ],

    'errors' => [
        'titles' => [
            'page-not-found' => 'Página não encontrada!',
            'registry-not-found' => 'Registro não encontrado.',
            'access-forbidden' => 'Acesso restrito',
            'internal-server-error' => 'Erro interno do servidor :(',
            'page-expired' => 'Página expirada',
        ],
        'messages' => [
            'link-is-broken' => 'O link está quebrado ou a página foi movida.',
            'access-forbidden' => 'Desculpe, mas você não tem permissão para acessar esta página.',
            'internal-server-error' => 'Por favor, reporte este erro para um administrador.',
            'page-expired' => 'Por favor, atualize a página e tente novamente.',
        ],
    ],

];
