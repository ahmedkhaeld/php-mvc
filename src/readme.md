# PHP Attributes
Attributes are essentially annotations that provide additional information about the code to tools, frameworks, and libraries.

Attributes in PHP are defined using the `#[Attribute]` syntax. To create a custom attribute,
you can create a new class and add the `#[Attribute]` declaration to it.
```php
#[Attribute]
class ReadOnly {
}

```
To use this attribute on a property, you can simply add the attribute to the property definition, like this:
```php
class User {
    #[ReadOnly]
    public string $readOnlyProperty;
}
```
Now, any code that needs to access the $readOnlyProperty property can check for the presence of the ReadOnly attribute and act accordingly.