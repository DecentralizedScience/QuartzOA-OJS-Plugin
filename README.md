# Build Plugin

To build the plugin, run:

``` bash
npm install --prefix Quartz-platform
npm --prefix Quartz-platform run build
PUBLIC_URL="../plugins/blocks/quartzOA/build/" npm --prefix Quartz-platform run build
mv -f Quartz-platform/build/* QuartzOAPlugin/build/
sed -i '1s/^/{literal}/' QuartzOAPlugin/build/index.html
sed -i -e '$a{/literal}' QuartzOAPlugin/build/index.html
```

Then, compress as `.tar.gz`file QuartzOA directory, and the plugin is ready to be installed, enabled and added to the side bar of your OJS journal:

```
tar -czvf QuartzOAPlugin.tar.gz QuartzOAPlugin
```
