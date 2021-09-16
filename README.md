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
  default_tag: DigitalAscetic\TagsBundle\Test\Entity\Tag
```

## How it works

To improve performance, this bundle exclude ManyToMany relation between entities. Instead ITaggable only store a json string with an array of Tag id's, and ITagRelationship stores the relation between entities.

Wit this logic, we improve the performance queries and reduce a lot of n+1 queries to database.

This bundle is based on 3 interfaces:

* __ITag__ -> Tag entity
* __ITaggable__ -> Entities with related tag(s).
* __ITagRelationship__ -> Entity that store the relation between tag and taggable entities.

### Bonus
If you need to work wit multiple ITag entities, you must implements this two interfaces:
* __ITaggable__
* __ITaggableTag__ -> Specify each ITag it work with 

Also we've implemented two Traits to simplify your code:

* TagTrait
* TaggableTrait

So you can simply add/remove tags to an entity like this:

```
        $taggable = new TaggableEntity();
        $taggable->addTag($tag1);
        $taggable->removeTag($tag2);
```

To find which entities has one or more tags related, you only need to query to your ITagRelationship entity, or maybe do a join between your ITaggable and ITaggableRelationship entities.

To get more information about it, you can see __Testing section__.

## Testing

Run:

```
./vendor/bin/simple-phpunit
```