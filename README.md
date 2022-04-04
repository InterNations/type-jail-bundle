# Type Jail Bundle

[![Test](https://github.com/InterNations/type-jail-bundle/actions/workflows/tests.yaml/badge.svg)](https://github.com/InterNations/type-jail-bundle/actions/workflows/tests.yaml)

Enforce super type contract of an object in a Twig template

## Installation

Install with `composer require internations/type-jail-bundle:*`. Add
`new InterNations\Bundle\TypeJailBundle\InterNationsTypeJailBundle()` in your `AppKernel.php` to load the bundle.

## Configuration
```
inter_nations_type_jail:
    enabled: # boolean (default: reflects the kernel.debug setting)
    factory: # one of jail, super_type_jail, jail (default: jail)
    types: # A map of type aliases to not use full qualified namespaces in a template
        fileInfo: SplFileInfo
```

## Usage

```twig
{% set file = jail(file, 'fileInfo') %}
```

```twig
{% set files = jail_aggregate(files, 'fileInfo') %}
```
