# Required Development Tools

The development of modules for the shop system requires some programs and tools. These include:

- A **webserver** (such as Apache or nginx) is needed to run the online shop software. For version GX 4.1, a
  webserver with a minimum PHP version of 7.2 is required.
- **[Git](https://git-scm.com/)** is used as a version management system for the source code of the shop software.
- **[Composer](https://getcomposer.org/)** is a package manager for PHP, that is used to install and manage PHP
  dependencies (like external PHP libraries).
- **[Node.js](https://nodejs.org/en/)** is a platform used for server-side execution of JavaScript code and serves
  as the basis for many of our development tools, such as Gulp.
- **[Yarn](https://yarnpkg.com)** is an alternative package manager for Node.js that can be used to install modules
  and development tools.


## Windows

We don't support Windows for development or production any longer. Please use a virtual machine or a different
operating system.


## Mac OS

**Homebrew** is a package manager for Mac OS. With the help of this package manager, you can easily install various
programs via the command line, which otherwise would have to be downloaded and installed manually from the
respective website. To install Homebrew, enter the following command in your terminal:

```sh
> /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
```

Homebrew should be installed afterwards. You can test the successful installation with the following command:

```sh
> brew -v

Homebrew 0.9.5 (git version b04f; last commit 2016-02-15)
```

If you receive a similar message, everything went perfectly.


### Git

First we use the following command to make sure Homebrew has the latest information about all packages:

```sh
> brew update

Updated Homebrew from d47bd54 to b40f107
...
```

Then we install Git:

```sh
> brew install git
```

To verify that Git has been installed correctly, you can run the following command in the terminal:

```sh
> git --version

git version 2.5.0
```


### Composer

Composer is not a part of PHP and therefore has to be installed manually:

* Navigate to the official [Composer website](https://getcomposer.org/download/).
* Execute the commands there in the terminal.

After a successful installation, the following command should output the installed Composer version:

```sh
> composer --version

Composer version 1.0-dev (a2fc502c208fcb3ac4700b934057a33ca130644b) 2016-01-18 12:41:09
```


### Node.js

Execute the following command inside the terminal to install Node.js:

```sh
> brew install node
```

After the installation is complete, you can check if the installation was successful by executing the following command:

```sh
> node -v

v4.0.0
```


### Yarn

Yarn is not part of Node.js and must therefore be installed manually:

* Navigate to the official [Yarn website](https://yarnpkg.com/en/docs/install).
* Execute the commands there inside a terminal.

After a successful installation, the following command should output the installed Yarn version:

```sh
> yarn --version
```


## Linux

Please note that depending on the distribution, some components may already be pre-installed.
If this is the case, we recommend that you update the corresponding components to the latest version.

Some Linux distributions also use different system package managers.
Ubuntu for example uses [Aptitude](https://wiki.ubuntuusers.de/aptitude/) *(apt)*. Fedora and
openSUSE use [rpm](http://rpm.org/) *(yum)*. In this tutorial, we assume that you use **Aptitude**.


### Git

In most Linux distributions, such as Ubuntu, Git should already be installed. To check if Git is available, you can
run the following command in the terminal:

```sh
> git --version
```

If Git is available, an output of the version should follow. If not, Git must be installed, which can be done with
the following command:

```sh
> sudo apt-get install git
```

### Composer

Composer is not a part of PHP and therefore has to be installed manually:

* Navigate to the official [Composer website](https://getcomposer.org/download/).
* Execute the commands there in the terminal.

After a successful installation, the following command should output the installed Composer version:

```sh
> composer --version
```

### Node.js

Execute the following commands in the terminal to install Node.js:

```sh
> curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash --
> sudo apt-get install -y nodejs
```

After installation, you can check if the installation was successful by executing the following command:

```sh
> node -v
```


### Yarn

Yarn is not part of Node.js and therefore has to be installed manually:

* Navigate to the official [Yarn website](https://yarnpkg.com/en/docs/install).
* Execute the commands there in the terminal.

After a successful installation, the following command should output the installed Yarn version:

```sh
> yarn --version
```
