# Changelog

Changes to Nomadic CSS Utilities that matter to a build, newest first. The
plugin has no releases, so each section is the day the change landed on
`main`. A site runs the copy it was deployed with.

The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/).
Housekeeping (formatting passes, punctuation and spelling sweeps) is not
listed. `git log` has every commit.

## 2026-10-08

### Changed

- The plugin is proprietary, with a LICENSE file, in place of GPLv2. The plugin
  header says so.

## 2026-08-13

### Fixed

- The pre-commit hook always uses the repo root's Prettier config, and it
  reports a Prettier error in place of a silent pass.

## 2026-08-07

### Added

- `.githooks/pre-commit` blocks a commit that has a PHP syntax error or an
  unformatted file. Enable it once per clone with
  `git config core.hooksPath .githooks`.

### Changed

- CSS Class Manager orders the classes through its own priority setting. Base
  classes come first, then `tablet:`, then `desktop:`.

## 2026-03-04

### Added

- The plugin: `n-` prefixed utility classes for the block editor, registered
  with CSS Class Manager so an editor can apply them from a picker. Every rule
  takes `!important` to beat the editor's inline styles. Classes are mobile
  first, with `tablet:` (768px) and `desktop:` (1024px) variants.
- Classes for display, flex, grid, alignment, order, column span, width,
  height, aspect ratio, object fit, overflow, spacing (with `n-p-*` and `n-m-*`
  for all sides), border radius (`n-rounded-9999` for a pill), and type
  (weight, style, transform, line height, letter spacing).
- An admin notice asks an administrator to install CSS Class Manager when it is
  not active.
- An editor guide in the README for the client: how the names work, the
  responsive prefixes, and common patterns.
