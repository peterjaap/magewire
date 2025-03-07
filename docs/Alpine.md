# Magewire - Alpine

## Magewire Component Interaction
From any Alpine component inside a Livewire component, you can access a magic $wire object to access and manipulate the
Livewire component.
```php
class Explanation extends \Magewirephp\Magewire\Component
{
    public $foo = 'bar';
}
```

```html
<div>
    <div x-data>
        <h1 x-text="$wire.foo"></h1>

        <button x-on:click="$wire.set('foo', Math.random())">Increment</button>
    </div>
</div>
```

> ```$wire``` gives you access to the Magewire component properties using AlpineJS. To avoid a misunderstanding your could
> also use ```wire:click="$set('foo', Math.random())'"``` to set the ```foo``` property value. It just to demonstrate
> how ```x-text``` could be used in combination with Magewire.
