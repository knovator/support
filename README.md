
Features:
- API response with specific response code
- Destroy Model Object
- Model Events
- Resource collection with records count
- Generate dynamic slug with using specified column
- update trashed record
- yajra datatable overwritted
You want to need add support repository in your composer.json file.

```
"repositories": [
          {
              "type": "vcs",
              "url": "git@github.com:knovator/support.git"
          }
      ],
```

Require the knovator/support package in your composer.json and update your dependencies:

```
    composer require knovator/support
 ```

website : [ https://github.com/knovator/support ]
