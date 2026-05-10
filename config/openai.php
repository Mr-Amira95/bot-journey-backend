<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key
    |--------------------------------------------------------------------------
    |
    | This value is the API key for your OpenAI account. You can find this
    | in your OpenAI dashboard.
    |
    */

    'api_key' => env('OPENAI_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | OpenAI Base URL
    |--------------------------------------------------------------------------
    |
    | This is the base URL for the OpenAI API. Default is the official API.
    |
    */

    'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),

    /*
    |--------------------------------------------------------------------------
    | OpenAI Model
    |--------------------------------------------------------------------------
    |
    | This is the model that will be used for the chatbot responses.
    |
    */

    'model' => env('OPENAI_MODEL', 'gpt-4.1'),

];
