AxisModuleRouting Plugin
========================

Installation
------------

### Composer way

Just add `axis/axis-module-routing-plugin` dependency to your `composer.json` file:
```json
  "require": {
    "axis/axis-module-routing-plugin": "dev-master"
  }
```

### Git way

Also you can clone `https://github.com/e1himself/axis-module-routing-plugin.git` to `plugins/AxisModuleRoutingPlugin` 
folder in your project.

Usage
-----

You can create `module_routing.yml` files within module's `config` dir.
All routes defined in `module_routing.yml` from enabled modules' config folders will be added to application routing.

### Additional options

#### `position` option

You can define `position` of a route to tell where it should be added to applicaiton routing: at the end or at the beginning. 
The only supported value for now is `last` - route will be appended to the end. Otherwise it will be prepended.
Default is to prepend.