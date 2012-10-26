### Heading samples

# H1

## H2

### H3

#### H4

##### H5

     Headings are creating using the hastag `#`, The number of hashtags represents the type of heading 
     # H1 
     ## H2
     ### H3
     #### H4
     etc

### Paragraphs

Paragraphs are created by entering text on a free line. There is no special syntax required to generate `<p>` tags

### Code blocks

Code blocks will be wrapped with `<pre>` tags and are created by indenting with 4 spaces before your text.

    $this->Foo->bar(); // some code because its indented

    Inline <code> tags are created by wrapping text with `backticks`

### Lists

Lists are created using either of the following: (there should be a `new line` before and after the list)

- `-`
* `*`

    - list
    - list 
    - list

1. You can also use numbered lists
2. Another number

    1. You can also use numbered lists
    2. Another number

### Block Quotes

> You can create nice looking block quotes using the `>`

    > This is a block quote

### Text formatting

You can easily create **bold** and _italics_ text

    Use two * stars for **bold** text, and underscores for _italics_ 

### Links

Normal links such as http://infinitas-cms.org are automatically linked, they can also be created with [custom text](http://infinitas-cms.org) eg: `\[custom text\]\(http://infinitas-cms.org\)`

### Images

Images can be inserted with ease. `\!\[\]\(/users/img/icon.png\)`

![](/users/img/icon.png)

And even with a title `\!\[\]\(/users/img/icon.png\ "custom title")`

![](/users/img/icon.png "custom title")

### Inline HTML

You can include inline HTML 

<table style="width: 100%">
  <tr><th>Foo</th><th>Bar</th><th>Baz</th></tr>
  <tr><td>1</td><td>2</td><td>3</td></tr>
  <tr><td>a</td><td>a</td><td>a</td></tr>
</table>

    <table style="width: 100%">
      <tr><th>Foo</th><th>Bar</th><th>Baz</th></tr>
      <tr><td>1</td><td>2</td><td>3</td></tr>
      <tr><td>a</td><td>a</td><td>a</td></tr>
    </table>

<div style="width: 200px; background-colour: gray; margin: auto">
  **Center**
</div>

    <div style="width: 200px; background-colour: gray; margin: auto">
      \*\*Center\*\*
    </div>

### Escaping

If you need to put a literal character such as a \*, \_ or \<p\> you can use the \\ (Which also needs to be escaped)

- `\` \\\\
- `\*` \\\*
- `\_` \\\_
- `backtick` \\\`
- `\{` or `\}` \\{ and \\\}
- `\[` or `\]` \\[ and \\\]
- `\(` or `\)` \\( and \\\)
- `\#` \\\#
- `\+` \\\+
- `\-` \\\-
- `\.` \\\.
- `\!` \\\!

### Mixing tags

You can mix and match various tags such as `**Bold code**` or image links `\[\!\[\]\(/users/img/icon.png "custom title"\)\]\(/admin\)`. There are some styles to set image sizes so this one is a bit bloated.

[![](/users/img/icon.png "custom title")](/admin)
