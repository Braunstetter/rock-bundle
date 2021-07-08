# Template Hooks

Rock templates give you an opportunity to hook into them using the `hook` tag.

Rock templates provide usually hooks. For example:

```{% hook 'my-custom-hook-name' %}```

To "hook into this" just create a class and extend `Rock\Core\Twig\TemplateHook`:

```php
namespace App\Twig;

use Rock\Core\Twig\TemplateHook;

class MyHook extends TemplateHook
{

    public function render(): string
    {
        return $this->templating->render('my-template.html.twig');
    }

    public function setTarget(): string
    {
        return 'my-custom-hook-name';
    }

}
```

And yes - you are done so!

Two methods are neccessary. `render` and `setTarget`. Render is for rendering the template you want to inject. And the `setTarget`method tells Rock which hook you want to use.