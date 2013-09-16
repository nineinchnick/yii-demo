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
my $silverId = $dbh->selectrow_array("SELECT id FROM ${prefix}precious_metals WHERE name = 'Silver'");

my @parts;
my $today = DateTime->today();

my $goldLastDate = $dbh->selectrow_array("SELECT max(date) FROM ${prefix}precious_metal_fixings WHERE currency_id = $currencyId AND precious_metal_id = $goldId");
@parts = split('-',!$goldLastDate ? '2002-01-01' : substr($goldLastDate, 0, 10));
$goldLastDate = DateTime->new(year => $parts[0], month => $parts[1], day => $parts[2]);
my $silverLastDate = $dbh->selectrow_array("SELECT max(date) FROM ${prefix}precious_metal_fixings WHERE currency_id = $currencyId AND precious_metal_id = $silverId");
@parts = split('-',!$silverLastDate ? '2002-01-01' : substr($silverLastDate, 0, 10));
$silverLastDate = DateTime->new(year => $parts[0], month => $parts[1], day => $parts[2]);

my $stmt_insert = $dbh->prepare("INSERT INTO ${prefix}precious_metal_fixings (precious_metal_id, currency_id, date, rate) VALUES (?,?,?,?)");

while ( $goldLastDate->add(days => 1) <= $today ) {
	print "Checking ",$goldLastDate;
	my @fixing = $lbma->dailygoldfixing( year => $goldLastDate->year(), month => $goldLastDate->month(), day => $goldLastDate->day());
	if (@fixing) {
		$stmt_insert->execute($goldId, $currencyId, $goldLastDate->ymd('-'), $fixing[1]*100);
	}
}

while ( $silverLastDate->add(days => 1) <= $today ) {
	print "Checking ",$silverLastDate;
	my @fixing = $lbma->dailysilverfixing( year => $silverLastDate->year(), month => $silverLastDate->month(), day => $silverLastDate->day());
	if (@fixing) {
		$stmt_insert->execute($silverId, $currencyId, $silverLastDate->ymd('-'), $fixing[1]*100);
	}
}

#$dbh->rollback;
$dbh->commit;
$dbh->disconnect;

