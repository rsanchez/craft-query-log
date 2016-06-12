# Query Log Plugin for Craft CMS

Show a log of database queries in your front-end templates.

![Screenshot](https://raw.githubusercontent.com/wiki/rsanchez/craft-query-log/screenshot.png)

## Usage

Add this to the bottom of your template:

```
{{ craft.querylog | raw }}
```

The ideal location is in your master layout, just before the final closing `</html>` tag.

When Craft `devMode` is set to `true`, this will add a Query Log button to the bottom of your page. Click it to reveal a list of all queries executed on the page.