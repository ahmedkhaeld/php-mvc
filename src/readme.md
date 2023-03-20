# Emails
Sending emails could be a heavy process, and could take a few seconds to complete. If you want to send emails in the background, you can use the `queue` method. This method will send the email to a queue, and will be processed by a worker. 
You can queue emails and have some sort of php script run in the background at a given schedule which then can pick
up the emails from the queue and send them. This is a very common pattern in web applications.

```sql 
emails(
    id: int,
    subject: string,
    status: string,
    created_at: datetime,
    meta: json
    htmlbody: longtext,
    textbody: longtext,
    sent_at: datetime
)
```