# Generators
provide an easy way to implement simple `Iterators` without the overhead or complexity of implementing a class that
implements the `Iterator` interface.

A generator allows you to write code that uses foreach to iterate over a set of data without needing to build an array
in memory, which may cause you to exceed a memory limit, or require a considerable amount of processing time to generate.

You can write a generator function, which is the same as normal function, except that it uses the `yield` keyword to
 provide a values to be iterated over.

```php
range(string|int|float $start, string|int|float $end, int|float $step = 1): array

// crate an array containing a range of elements
```

```php
class GeneratorExampleController
{

    public function __construct()
    {
    }

    public function index():void
    {
        $numbers=range(1,10);

        echo '<pre>';
        print_r($numbers);
        echo '<pre>';

    }
}
```
```
this created array is built in memory once the `range` function is called, and consumes memory. If you have a large range of numbers, you may
exceed the memory limit of your server.
Exceeding memory depends on few factors:
- the memory limit is set for the environment 
- the memory of each element in the array consumes
```

##### using generators
* in order to use generators, we need to create a custom range function as generator function 
* `yield` **pauses** the execution of the function, and returns a value from it.
* the next time the generator function is called, it will resume from where it left off, and **continue execution**.
* the current method fetches the current value from the generator.
* the next method advances the generator to the next value.



```php


    public function index():void
    {
        $numbers=$this->lazyRange(1,10);

      echo $numbers->current();
      $numbers->next();
      echo $numbers->current();


    }

    private function lazyRange(int $start, int $end) : \Generator
    {
        for ($i = $start; $i <= $end; $i++) {
            yield $i;
        }
    }
```
To print a key value pair
```php
 public function index():void
    {
        $numbers=$this->lazyRange(1,10);

       foreach ($numbers as $key=> $number) {
            echo $key . ':'. $number;
        }


    }

 private function lazyRange(int $start, int $end) : \Generator
    {
        for ($i = $start; $i <= $end; $i++) {
            yield $i;
        }
    }
```
You can manipulate the key inside the generator function <br>
this will adjust the key value pair 
```php
private function lazyRange(int $start, int $end) : \Generator
    {
        for ($i = $start; $i <= $end; $i++) {
            yield $i => $i;
        }
    }
```
> generators help to reduce the memory consumption of the application<br>
> generators are useful when you need to iterate over a large set of data, but don't want to load all the data into memory at once.<br>
> 
> Another solutions to avoid memory consumption using:<br>
> Pagination<br>
> Filtering<br>
> Narrow selection [select only the fields you need]<br>

---
### Database example using generators


* Generator Disadvantages
    * Generators are not be rewindable that already run (you cannot call `rewind` on them) 
    * Generators cannot be iterated over more than once
