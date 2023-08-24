![logo-no-background](https://github.com/lkas96/Scoob-Site/assets/103634851/c4509a44-f1f5-4859-a174-6e864cabbed2)


# Requirements
To use Expo, you need to have the following tools installed on your machine:
- [Node.js LTS release](https://nodejs.org/en/) - Only Node.js LTS releases (even-numbered) are recommended.
As Node.js officially states, "Production applications should only use Active LTS or Maintenance LTS releases". You can install Node.js using a version management tool (such as `nvm` or `volta` or any other of your choice) to switch between different Node.js versions.
- [Git](https://git-scm.com/) for source control.
- [Watchman](https://facebook.github.io/watchman/docs/install#buildinstall) (for Linux or macOS users).

# Get Started
After installing Node.js, and downloading our source code (either through downloading the zip file or cloning from our repo), you can use `cd` into the `ScoobMobileV2` directory and use `npx` to start the app.
```zsh
# To change directory to ScoobMobileV2
cd ScoobMobileV2

# To download relevant dependencies on local machine
npm install

# To start the application on your machine
npx expo start
```

> If you encounter any issues with loading the application from the QR code consider starting the application using a `--tunnel` method.
> ```zsh
> # Alternate way to start the application
> npx expo start --tunnel
> ```


After starting the application successfully, you will be presented with a QR code and other details as such. \
![image](https://github.com/lkas96/Scoob-Site/assets/103634851/d5055d7b-b21c-4303-be17-dcabc28dcf01)


In order to run the application on your mobile device, install **Expo Go App** on your mobile using the following links. \
[App Store Link](https://itunes.apple.com/app/apple-store/id982107779)	\
[Google Play Store Link](https://play.google.com/store/apps/details?id=host.exp.exponent&referrer=www) 

After downloading **Expo Go** on your mobile device, simply Scan the QR code above with **Expo Go (Android)** or the **Camera app (iOS)**.

Once scanned and loaded, you will be able to start your journey with Scoob!! :smiley:
