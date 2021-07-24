# Installation

Start by downloading the bundle with composer:

`composer require braunstetter/rock-bundle`

Now you just have to import the routes.
Create a `rock.yaml` file inside of your `config/routes`folder. 

And paste: 

```yaml
rock:
  resource: .
  type: rock_admin
  prefix: /cp
```

You can change the prefix. So your backend is accessible from a different route prefix. Maybe you prefer `/admin` instead of `/cp`.
