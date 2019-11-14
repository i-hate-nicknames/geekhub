#!/bin/sh
prefix="/application/var/mails/new"
numPath="/application/var/mails/sendmail"

mkdir -p /application/var/mails/new
mkdir -p /application/var/mails/sendmail

if [ ! -f $numPath/email_numbers ]; then
echo "0" > $numPath/email_numbers
fi
emailNumbers=`cat $numPath/emailNumbers`
emailNumbers=$(($emailNumbers + 1))
echo $emailNumbers > $numPath/emailNumbers
name="$prefix/letter_$emailNumbers.eml"
while IFS= read line
do
echo "$line" >> $name
done
chmod 777 $name
/bin/true
