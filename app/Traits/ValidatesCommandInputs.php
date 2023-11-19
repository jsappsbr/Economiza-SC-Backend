<?php

namespace App\Traits;

use Illuminate\Console\Concerns\HasParameters;
use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Support\Facades\Validator;

trait ValidatesCommandInputs
{
    use HasParameters;
    use InteractsWithIO;

    public function validate(array $argumentRules = null, $optionRules = null): array
    {
        $arguments = $argumentRules
            ? $this->validateArguments($this->arguments(), $argumentRules)
            : $this->arguments();

        $options = $optionRules
            ? $this->validateOptions($this->options(), $optionRules)
            : $this->options();

        return [$arguments, $options];
    }

    protected function validateOptions(array $options = [], array $rules = []): ?array
    {
        $validator = Validator::make($options, $rules);

        if ($validator->fails()) {
            $this->error('Whoops! The given options are invalid.');

            collect($validator->errors()->all())
                ->each(fn ($error) => $this->line($error));
            exit;
        }

        return $validator->validated();
    }

    protected function validateArguments(array $arguments = [], array $rules = []): ?array
    {
        $validator = Validator::make($arguments, $rules);

        if ($validator->fails()) {
            $this->error('Whoops! The given attributes are invalid.');

            collect($validator->errors()->all())
                ->each(fn ($error) => $this->line($error));
            exit;
        }

        return $validator->validated();
    }
}
