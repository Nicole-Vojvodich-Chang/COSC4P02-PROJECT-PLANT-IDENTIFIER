// jest.setup.js
require('jest-fetch-mock').enableMocks();

const { JSDOM } = require('jsdom');
const jsdom = new JSDOM('<!doctype html><html><body></body></html>');
const { window } = jsdom;

global.window = window;
global.document = window.document;
global.fetch = require('jest-fetch-mock');
