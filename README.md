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
  tags_relations_indexation:
    tag:
      class_name: 'DigitalAscetic\TagsBundle\Test\Entity\Tag'
```

## How it works

First you need to create your Tag entity class that must implements _ITag_ interface.

Every entity you want to be "tagged", it must implement _ITaggable_ interface.

> You can use TagTrait and TaggableTrait to simplify.

You can inject our _TagManagerInterface_ service to add, remove or find tags:

```
/** Add tag(s) to entity taggable **/
public function packTags(ITaggable $taggable, array $tags, bool $indexed = true): void;

/** Remove tag(s) from entity taggable **/
public function unPackTags(ITaggable $taggable, array $tags, bool $indexed = true): void;

/** Find ITaggable entities that have a ITag related. **/
public function findByTag(ITag $tag, string $category = null): TagQueryResult;
```


To get more information about it, you can see __Testing section__.

## Testing

Run:

```
./vendor/bin/simple-phpunit
```