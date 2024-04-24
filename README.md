# Headless WordPress Proof of Concept

This is a proof on concept project for displaying a list of movies with a Headless WordPress setup via Next.js

## Requirements/Install/Setup

> WARNING: This setup assumes a Linux-based system (Linux, macOS, Windows >= 10 w/ WSL) running node version ~18 with
> npm version ~8 and Docker. If you have trouble running anything, it probably has something to do with the above.

1. Fork this repo, clone it to your local and cd into the directory.
1. Run `npm install`
1. Run `npm run env:init`
1. Run `npm run env:launch`
1. Run `./bin/wp.sh gbr create-sample-content`
1. Run `cd react-app`
1. Run `npm install`
1. Run `npm run dev`

## How to Use

Once the above commands have ran, you can now do the following:
1. Go to http://localhost:3000/ and click around the site
1. (optional) If you want to see the WordPress backend and make changes, you can go to http://localhost:8888/wp-admin/ and login with admin/password

## Enhansements to make in the future

1. Add unit testing to this project
1. Assess the site for accessablity enhancements (example: test using voiceover)
1. Remove duplicate code in react app by creating shared components for similar code
1. Update images in react app to use Next.js Image component
1. Implament endpoind caching for Next.js app
1. Update SASS app to use a cleaner media query setup (with variables etc)
1. Update media import to be a little cleaner and import several images
1. Look into updating WP-CLI script to call other WordPress CLI scripts instead of calling WordPres php functions
1. Update WP-CLI script to account for additional edge cases
1. Cleanup the frontend layout of the react app (spacing etc)
1. Cleanup boilerplate content in react app
1. Automate new setup scripts