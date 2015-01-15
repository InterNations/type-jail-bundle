# Type Jail Bundle

[![Build Status](https://travis-ci.org/InterNations/type-jail-bundle.svg?branch=master)](https://travis-ci.org/InterNations/type-jail-bundle) [![Dependency Status](https://www.versioneye.com/user/projects/54b7a64e05064657eb0001bd/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54b7a64e05064657eb0001bd) [![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/InterNations/type-jail-bundle.svg)](http://isitmaintained.com/project/InterNations/type-jail-bundle "Average time to resolve an issue") [![Percentage of issues still open](http://isitmaintained.com/badge/open/InterNations/type-jail-bundle.svg)](http://isitmaintained.com/project/InterNations/type-jail-bundle "Percentage of issues still open")

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
