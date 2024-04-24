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
1. Run `./bin/wp.sh rewrite flush`
1. Run `cd react-app`
1. Run `npm install`
1. Run `npm run dev`
1. Go to http://localhost:8888/wp-admin/options-permalink.php and login (admin/password)
1. Go to http://localhost:3000/ and enjoy

or just run the following:
`gh repo clone djp424/headless-wordpress; cd headless-wordpress; npm install; npm run env:init; npm run env:launch; ./bin/wp.sh gbr create-sample-content; ./bin/wp.sh rewrite flush; cd react-app; npm install; npm run dev`

then:
1. Go to http://localhost:8888/wp-admin/options-permalink.php and login (admin/password)
1. Go to http://localhost:3000/ and enjoy

## How to Use

After setup, simply go to http://localhost:3000/ and enjoy

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
1. Automate last step where you need to login to wordpress to make the rest api work on setup
1. Add more comments to the react app
