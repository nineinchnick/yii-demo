#!/usr/bin/perl
use warnings;
use strict;

use LBMA::Statistics;
use Log::Log4perl qw/:easy/;

use DBI;

use DateTime;

my $dbname = 'data/testdrive.db';
#my $dbhost = 'localhost';
#my $dbport = '5432';
my $dbuser = '';
my $dbpass = '';
#my $connectionString = "dbi:Pg:dbname=$dbname;host=$dbhost;port=$dbport;";
my $connectionString = "dbi:SQLite:dbname=$dbname";
my $prefix = 'tbl_';

Log::Log4perl->easy_init();

my $lbma =  LBMA::Statistics->new();

my $dbh = DBI->connect($connectionString, $dbuser, $dbpass, {AutoCommit => 0}) or die ('Cant connect to database.');

my $currencyId = $dbh->selectrow_array("SELECT id FROM ${prefix}currencies WHERE code = 'USD'");
my $goldId = $dbh->selectrow_array("SELECT id FROM ${prefix}precious_metals WHERE name = 'Gold'");
my $lastDate = $dbh->selectrow_array("SELECT max(date) FROM ${prefix}currency_fixings WHERE currency_id = $currencyId");
my @parts = split('-',!$lastDate ? '2002-01-01' : substr($lastDate, 0, 10));
$lastDate = DateTime->new(year => $parts[0], month => $parts[1], day => $parts[2]);
my $today = DateTime->today();

my $stmt_insert = $dbh->prepare("INSERT INTO ${prefix}precious_metal_fixings (precious_metal_id, currency_id, date, rate) VALUES (?,?,?,?)");

while ( $lastDate->add(days => 1) <= $today ) {
	print "Checking ",$lastDate;
	my @fixing = $lbma->dailygoldfixing( year => $lastDate->year(), month => $lastDate->month(), day => $lastDate->day());
	if (@fixing) {
		$stmt_insert->execute($goldId, $currencyId, $lastDate->ymd('-'), $fixing[1]*100);
	}
}

#$dbh->rollback;
$dbh->commit;
$dbh->disconnect;

