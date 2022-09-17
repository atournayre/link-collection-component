# Link Collection Component

This component provides methods to help manage collection of links.

This component rely on Doctrine Collection and Symfony Web Link.

## Install
### Composer
```shell
composer require atournayre/link-collection-component
```

## Usages
Create a link collection generator
```php
<?php

namespace App\Generator;

use Exception;
use Atournayre\Component\LinkCollection;
use Symfony\Component\WebLink\Link;

class LinkCollectionGenerator
{
    /**
     * @throws Exception
     */
    public function __invoke(): LinkCollection
    {
        // Create links always available.
        $links = [
            (new Link())
                ->withHref('#')
                ->withAttribute('title', 'Anchor'),
            (new Link())
                ->withHref('https://google.com')
                ->withAttribute('title', 'Google'),
        ];

        $collection = new LinkCollection($links);

        // Add link conditionally to collection using a callback
        $collection->add(
            (new Link())
                ->withHref('https://bing.com')
                ->withAttribute('title', 'Bing'),
            fn () => false
        );

        // Add link conditionally to collection using a callback
        $collection->add(
            (new Link())
                ->withHref('https://yahoo.com')
                ->withAttribute('title', 'Yahoo')
                ->withAttribute('aria-expanded', true),
            fn () => true
        );

        return $collection;
    }
}
```

Use the link collection
```php
<?php

namespace App\Controller;

use Atournayre\Component\LinkCollection\Converter\HtmlConverter;
use Atournayre\Component\LinkCollection\Converter\JsonConverter;
use App\Generator\LinkCollectionGenerator;

class ExampleController extends AbstractController
{
    public function __invoke(
         LinkCollectionGenerator $linkCollectionGenerator,
    ): Response
    {
        return $this->render('index.html.twig', [
            // Get raw collection of Symfony\Component\WebLink\Link.
            'links' => $linkCollectionGenerator(),
            // Convert link collection to html.
            'htmlLinks' => HtmlConverter::getLinks($linkCollectionGenerator()),
            // Convert link collection to json.
            'jsonLinks' => JsonConverter::getLinks($linkCollectionGenerator()),
        ]);
    }
}

```


## Contributing
Of course, open source is fueled by everyone's ability to give just a little bit
of their time for the greater good. If you'd like to see a feature or add some of
your *own* happy words, awesome! Tou can request it - but creating a pull request
is an even better way to get things done.

Either way, please feel comfortable submitting issues or pull requests: all contributions
and questions are warmly appreciated :).
