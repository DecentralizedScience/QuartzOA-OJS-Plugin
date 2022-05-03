# Build Plugin

Download submodule:

```
git submodule update --init --recursive
```

Copy and update config file:

```
cp Quartz-platform/src/components/config.json.example Quartz-platform/src/components/config.json
```

To build the plugin, run:

``` bash
npm install --prefix Quartz-platform
PUBLIC_URL="../../plugins/blocks/quartzOA/build/" npm --prefix Quartz-platform run build
rsync -a Quartz-platform/build/* QuartzOAPlugin/build/
sed -i '1s/^/{literal}/' QuartzOAPlugin/build/index.html
sed -i -e '$a{/literal}' QuartzOAPlugin/build/index.html
```

Then, compress as `.tar.gz`file QuartzOA directory, and the plugin is ready to be installed, enabled and added to the side bar of your OJS journal:

```
tar -czvf QuartzOAPlugin.tar.gz QuartzOAPlugin
```
