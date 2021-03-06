# Generated by Django 2.1.1 on 2018-09-19 21:48

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('firstResponderDashboard', '0001_initial'),
    ]

    operations = [
        migrations.CreateModel(
            name='CallInstance',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('imprint', models.CharField(max_length=200)),
                ('due_back', models.DateField(blank=True, null=True)),
                ('status', models.CharField(blank=True, choices=[('m', 'Maintenance'), ('o', 'On loan'), ('a', 'Available'), ('r', 'Reserved')], default='m', help_text='Book availability', max_length=1)),
            ],
            options={
                'ordering': ['due_back'],
            },
        ),
        migrations.CreateModel(
            name='textInstance',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('imprint', models.CharField(max_length=200)),
                ('due_back', models.DateField(blank=True, null=True)),
                ('status', models.CharField(blank=True, choices=[('m', 'Maintenance'), ('o', 'On loan'), ('a', 'Available'), ('r', 'Reserved')], default='m', help_text='Book availability', max_length=1)),
            ],
            options={
                'ordering': ['due_back'],
            },
        ),
    ]
