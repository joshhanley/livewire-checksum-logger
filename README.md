# Livewire Checksum Logger

This package dumps Livewire's fingerprint and memo data to a log channel for debugging the "Livewire encountered corrupt data" error.

## Installation

To install the package run

```bash
composer require joshhanley/livewire-checksum-logger
```

## Usage

In your `.env` file, set the below option to true to enable and false to disable (or remove)

```
LIVEWIRE_CHECKSUM_LOGGER_ENABLED=true
```

You can also specify which channel the package will use. Currently it will use Laravel's `log` by default, but also has support for `ray`

```
LIVEWIRE_CHECKSUM_LOGGER_CHANNEL=ray
```

Once your env variables have been configured, make an initial request that contains a Livewire component.
You should see the Livewire component ID and "RESPONSE" with the fingerprint and memo payloads.

Then trigger a Livewire request, and you should see the Livewire component ID and "REQUEST" with the fingerprint and memo payloads.

You can then manually compare these to see if there are any differences.

Here is a sample of how it looks in ray:

![ray example](https://raw.githubusercontent.com/joshhanley/livewire-checksum-logger/main/images/ray-example.png)

And sample log output:

![log example](https://raw.githubusercontent.com/joshhanley/livewire-checksum-logger/main/images/log-example.png)
