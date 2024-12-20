<?php

declare (strict_types=1);

namespace Honed\Honed\Release\ReleaseWorker;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Release\Exception\MissingComposerJsonException;
use MonorepoBuilderPrefix202408\Symplify\SmartFileSystem\SmartFileInfo;

final class SetRootComposerVersion implements ReleaseWorkerInterface
{
    public function __construct(
        protected ComposerJsonProvider $composerJsonProvider, 
        protected JsonFileManager $jsonFileManager
    ) {
        $this->composerJsonProvider = $composerJsonProvider;
        $this->jsonFileManager = $jsonFileManager;
    }

    public function work(Version $version) : void
    {
        dd($version);
        // $rootComposerJson = $this->composerJsonProvider->getRootComposerJson();
        // $replace = $rootComposerJson->getReplace();
        // $packageNames = $this->composerJsonProvider->getPackageNames();
        // $newReplace = [];
        // foreach (\array_keys($replace) as $package) {
        //     if (!\in_array($package, $packageNames, \true)) {
        //         continue;
        //     }
        //     $newReplace[$package] = $version->getVersionString();
        // }
        // if ($replace === $newReplace) {
        //     return;
        // }
        // $rootComposerJson->setReplace($newReplace);
        // $rootFileInfo = $rootComposerJson->getFileInfo();
        // if (!$rootFileInfo instanceof SmartFileInfo) {
        //     throw new MissingComposerJsonException();
        // }
        // $this->jsonFileManager->printJsonToFileInfo($rootComposerJson->getJsonArray(), $rootFileInfo);
    }

    public function getDescription(Version $version) : string
    {
        return 'Setting "version" in "composer.json" to the new version tag.';
    }
}
