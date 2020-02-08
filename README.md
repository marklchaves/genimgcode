# genimgcode

## Description

Generate markup to display images on web pages by reading a directory (folder) of prepared images. Current iteration is written in PHP.

Based on [Gallery From Folder by David Carr](https://daveismyname.blog/creating-an-image-gallery-from-a-folder-of-images-automatically).

This is a work in progress.

## Recent Modification History

8 February 2020
- Added error handling for valid but empty directory or directory with no images.
- Now should process only image files.
- Created dedicated directory for the code to live.

12 January 2020
- Created index.html to support input/output paths and alt settings.
- Created style.css.

6 January 2020
- Added Liquid support for Minimal Mistakes Jekyll theme.
- Refactored to support converting filenames to alt and title tags.

## Wish List

- Create JavaScript version. 
- Maybe create React JS version. 
- Add admin interface to specify custom image directory, alt tag text, and title text. **DONE 12 JAN 2020**

## Current Output Formats

1. Liquid front matter for the Minimal Mistakes Jekyll theme. My [main portfolio site](https://caughtmyeye.dev) is built on Jekyll.
2. HTML

## Future Output Formats?

1. AMP Story
2. Json

<hr>

## Example Output

