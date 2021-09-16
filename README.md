Digital Ascetic Tags Bundle
=======

## Installation

```
composer require digitalascetic/tags
```

Add this bundle to your AppKernel:

```
public function registerBundles()
    {
        return array(
            ...
            new \DigitalAscetic\TagsBundle\DigitalAsceticTagsBundle(),
        );
    }
```

## Configuration

This bundle is disabled by default. You need to enable explicitly:

```
digital_ascetic_tags:
  enabled: true
```

## How it works

First you need to create your Tag entity class that must implements _ITag_ interface.

Every entity you want to be "tagged", it must implement _ITaggable_ interface, and you must create a new entity that implements ITagRelationship.


To get more information about it, you can see __Testing section__.

## Testing

Run:

```
./vendor/bin/simple-phpunit
```