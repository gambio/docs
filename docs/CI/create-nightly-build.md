# How to Set Up a Nightly Build for a Specific Branch

To configure a Nightly Build that runs every day at a specific time, follow these steps:

1. Visit the pipeline schedules overview page: [Pipeline Schedules](https://sources.gambio-server.net/gambio/gxdev/-/pipeline_schedules)
2. Click on "New schedule"
3. Provide a descriptive name for the schedule, indicating the purpose and the target branch for the Nightly Build.
4. Specify the interval for the Nightly Build. Typically, it runs every day at night. However, you can use any cron syntax to customize the interval pattern. For assistance with the cron syntax, you can consult [Crontab.guru](https://crontab.guru/)
5. Choose `GXCI_schedules` as the target branch for the Nightly Build.
6. Add the following variables:
    - Key: `CI_SCHEDULE_ACTION`, Value: `build_nightly_version`
    - Key: `CI_SCHEDULE_BRANCH`, Value: `<the target branch name>`
7. Click "Save pipeline schedule" to complete the setup.

By following these steps, you'll have a Nightly Build set up for the specified branch, automatically running at the designated time every day.

## Editing the Pipeline in `.gitlab-ci.yml`

To customize the Nightly Build pipeline, you need to edit the `.gitlab-ci.yml` file in the branch `GXCI_schedules`. Within the `.gitlab-ci.yml` file, locate the section titled "Build nightly version".

In this section, you can define the specific tasks and steps that will be executed during the Nightly Build.

Remember to commit and push your changes to the `GXCI_schedules` branch after editing the `.gitlab-ci.yml` file. The changes will take effect during the next scheduled Nightly Build.

Make sure to test your changes thoroughly to ensure that the Nightly Build works as expected and meets your requirements.

## Triggering a Build Outside the Interval

If you need to run a Nightly Build outside the predefined interval, GitLab allows you to take ownership of the schedule and manually trigger a build. Follow these steps:

1. On the pipeline schedules page, locate your schedule and click the "Take ownership" button. (Note: This step is only required if you're not already the owner of the schedule.)
2. Once you've taken ownership, a "Play" button will be available, allowing you to start a build immediately, regardless of the interval settings.

Keep in mind that triggering a build manually can be helpful for testing purposes or urgent releases, but it's essential to use it judiciously to maintain the intended Nightly Build schedule.

That's it! Now you have a Nightly Build scheduled for your branch, you can customize the build process by editing the `.gitlab-ci.yml` file and you can manually trigger a build.