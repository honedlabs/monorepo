<?php

declare(strict_types=1);

namespace Honed\Data\Rules;

use Illuminate\Support\Facades\Http;
use Honed\Data\Support\AbstractRule;
use Symfony\Component\HttpFoundation\IpUtils;

class Recaptcha extends AbstractRule
{
    /**
     * Create a new rule instance.
     */
    public function __construct(
        protected ?string $ip
    ) {}

    /**
     * Check if the given value is valid in the scope of the current rule.
     */
    public function isValid(mixed $value): bool
    {
        $value = is_scalar($value) ? (string) $value : '';

        $response = Http::asForm()->post($this->getHost(), $this->getPayload($value));

        /** @var array{success: bool}|null $result */
        $result = $response->json();

        return $response->successful()
            && $result !== null
            && $result['success'] === true;
    }

    /**
     * Return the shortname of the current rule.
     */
    protected function shortname(): string
    {
        return 'recaptcha';
    }

    /**
     * Get the recaptcha host.
     */
    protected function getHost(): string
    {
        return config()->string('services.recaptcha.host', 'https://www.google.com/recaptcha/api/siteverify');
    }

    /**
     * Get the recaptcha secret.
     */
    protected function getSecret(): string
    {
        return config()->string('services.recaptcha.secret');
    }

    /**
     * Get the recaptcha payload.
     *
     * @return array{secret: string, response: string, remoteip: string}
     */
    protected function getPayload(string $value): array
    {
        return [
            'secret' => $this->getSecret(),
            'response' => $value,
            'remoteip' => IpUtils::anonymize((string) $this->ip),
        ];
    }
}
