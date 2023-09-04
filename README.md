# rate-limit

![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)

`kelunik/rate-limit` is a rate limiting library for [Amp](https://github.com/amphp/amp).

## Installation

```bash
composer require kelunik/rate-limit
```

## Usage

You're in full control of any actions when the rate limit is exceeded. You can also already warn the user before he exceeds the limit.

```php
$current = $this->rateLimit->increment("{$userId}:{$action}");

if ($current > $this->limit) {
    // show captcha or error page or do anything you want
} else {
    // request is within the limit, continue normally
}
```

If you want to expose the limits, e.g. in an HTTP API, you can also request the reset time for a given key.

```php
$current = $this->rateLimit->increment("{$userId}:{$action}");

$response->setHeader("x-ratelimit-limit", $this->limit);
$response->setHeader("x-ratelimit-remaining", $this->limit - $current);
$response->setHeader("x-ratelimit-reset", $this->rateLimit->getTtl("{$userId}:{$action}"));
```

`RateLimit::getTtl()` returns the seconds until the limit is reset. If you want to return the absolute time, you can just add `time()` to that value.
