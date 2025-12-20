<?php

// app/Helpers/EmailHelper.php

if (! function_exists('parseEmailTemplate')) {
    function parseEmailTemplate(string $body, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $body = str_replace('{{ '.$key.' }}', e($value), $body);
        }

        return $body;
    }
}
