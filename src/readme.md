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

#### After Enums
Enums provide a new way to define a set of named values that are strongly typed and iterable. Here's how you would define the same set of weekdays using enums:
```php
enum Weekday {
    case SUNDAY;
    case MONDAY;
    case TUESDAY;
    case WEDNESDAY;
    case THURSDAY;
    case FRIDAY;
    case SATURDAY;
}

```
* Enums are strongly typed, meaning you can't assign an arbitrary value to an enum. This provides additional type safety and makes code easier to reason about.
* Enums are namespaced, so there's no risk of naming conflicts with other parts of the code.
* Enums are iterable and countable, so you can easily loop over them or get a count of how many there are.
* Enums provide auto-completion, so you can easily see all the possible values.
* Enums can have methods and properties associated with them, which can be useful for encapsulating behavior related to the enum values
