## Open Source Casino
Unfortenantly due to pissing off [Softswiss.com](https://softswiss.com) this project never seen daylight, however the idea I've noted down below and maybe someone else can pick this up.

You can find more shit on respins.io or just simply by search 'softswiss' on github as usually I put this within a readme or whatever, so you can find other snippets all regarding casino shit.

F.e. mondogaming.eu etc. all those can be found.

Hopefully at some point @Ivan-Montik will man up and let me work for them while also stop hacking & bugging my pc's, but this is unlikely so feel free to use for whatever reason.


## Whats this
This what meant to be open source completely free casino utilizing metamask & a .js plugin that adapts and makes it so you can have a "casino" in any page.

It will automatically adapt and change for example it's font and whatever. It's not an iframe, instead it writes into to document, apart from that can also be used as a standalone casino.

The idea was to offer this with the plugin and basically take over completely the casino side and you can implement a casino (for example on those staking pages or coin pages) and then to offer additional services like implementing their coin etc.

## User System
User system should be anything but local, so that means login by metamask, login by solana version of metamask etc etc so that can offer a "global" uniform account system and thus can be implemented in any website using the plugin.

This makes so you can make it into service that has automatic onboarding and doesn't require f.e. API integration etc etc, simply customer puts the .js snippet in header and that's it.

## Dropinblog
The idea came from using dropinblog.com that has similar .js that adapts the content to the page it's being integrated on.

## Payment
The idea was to make money in the end on sub services (like offering full managed payments and whatever) and ofc the games & games data, for now though (if I remember correctly) it is using [cryptoapi.io](https://cryptapi.io/cryptocurrencies/) which in essense is a forwarding service.

There is no need for creating account on the cryptapi.io service, simply you can put the "end" address where you wish to receive the deposits in crypto on.



## Change LoginLimiter in Fortify Source:

If getting error regarding the login limiter, change withint he vendor on laravel/fortify the loginlimiter snippet to:
```
return Str::lower($request->input(Fortify::username())).'|'.$request->ip();
```
