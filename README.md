AxisModuleRouting Plugin
========================

Usage
-----

You can create `module_routing.yml` files withing module's `config` folder.
All routes defined in `module_routing.yml` from enabled modules' config folders will be added to application routing.

### Additional options

#### `position` option

You can define `position` option. The only supported value for now is `last`. It allows to control route position
when adding to whole routing collection.