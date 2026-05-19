# Laravel 11 Bootstrapping Deadlock

## Problem
In Laravel 11, when using `Application::configure()->withProviders([...])`, the application might encounter a deadlock where it tries to resolve the `config` service during the `registerConfiguredProviders()` phase, but the `config` service itself hasn't been bound yet because the providers responsible for it are still being registered.

## Cause
`RegisterProviders::merge()` is called during the `withProviders()` configuration phase. This calls `mergeAdditionalProviders()`, which attempts to access `$app->make('config')`. However, `config` is only bound during the `bootstrap()` phase of the `Kernel`, which occurs *after* the configuration phase.

## Solution
1. Ensure all core service providers (like `ConfigServiceProvider`, `TranslationServiceProvider`, `ValidationServiceProvider`) are correctly listed in `config/app.php` and/or `bootstrap/app.php`.
2. In testing environments, ensure the `Kernel` is resolved and `handle()` is called to trigger the full bootstrap process.
3. If manually bootstrapping, ensure the `config` service is bound before attempting to register providers that depend on it.
