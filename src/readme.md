# PHP Enums

#### Before Enums
we would use constant values or class constants to represent a limited set of options or values
```php
class Weekday {
    const SUNDAY = 0;
    const MONDAY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;
}

```
This approach has several drawbacks:
1. It doesn't provide any type safety. You can assign any integer value to a variable of type Weekday.
2. It doesn't provide any auto-completion. You have to remember the names of the constants.
3. Constants are global. If you have two classes with constants named the same, you can't use both in the same scope.
4. Constants are not iterable or countable, so you can't use them in a foreach loop or with the count() function.