# ccb-login Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## 2.0.1 - 2023-07-08

### Fixed

- Fixed bug where the plugin attempted to create new sessions rather than using the existing session.

## 2.0.0 - 2021-05-06

### Changed

- Changed Name to Comply with Craft's guidelines
- This changes the form controller location from: `craft-ccb-login/default` to `ccb-login/default`. Change the action input in your templates to: `<input type="hidden" name="action" value="ccb-login/default/">`.
- Also changed the session var name from `craftccblogin` to `craftccblogin`. Change all instances of `craft.craftccblogin.userSession` in your templates to `craft.ccblogin.userSession`.

## 1.0.9 - 2019-05-10

### Added

- Initial release
