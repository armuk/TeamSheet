//
//  SigninViewController.m
//  Team Sheet
//
//  Created by James Guthrie on 15/02/2013.
//  Copyright (c) 2013 Hey Jimmy. All rights reserved.
//

#import "SigninViewController.h"
#import "PhotoViewController.h"
#import "StaffMember.h"

@interface SigninViewController ()

@end

@implementation SigninViewController

@synthesize inputTextField, accountUUID, staffIDArray, staffPINArray, headerLabel, timeLabel;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    [inputTextField setBorderStyle:UITextBorderStyleRoundedRect];
    [inputTextField setBackgroundColor:[UIColor whiteColor]];
    [NSTimer scheduledTimerWithTimeInterval: 1.0
                                                      target: self
                                                    selector: @selector(showTime)
                                                    userInfo: nil
                                                     repeats: YES];
    NSString *parsedAccountURL = [NSString stringWithFormat:@"%@%@%@", @"https://clockinoutapp.appspot.com/_je/", accountUUID, @"-account"];
    NSURL *accountURL = [NSURL URLWithString: parsedAccountURL];
    NSMutableURLRequest *accountRequest = [NSMutableURLRequest requestWithURL:accountURL
                                                                  cachePolicy:NSURLRequestReloadIgnoringLocalCacheData
                                                              timeoutInterval:60];
    accountDetailsConnection = [[NSURLConnection alloc] initWithRequest:accountRequest delegate:self];
}

- (void)showTime{
NSDateFormatter *formatter = [[NSDateFormatter alloc] init];
    [formatter setDateFormat:@"hh:mm a"];
    NSString *dateToday = [formatter stringFromDate:[NSDate date]];
    [timeLabel setText:dateToday];
}

- (NSCachedURLResponse *)connection:(NSURLConnection *)connection willCacheResponse:(NSCachedURLResponse *)cachedResponse {
    return nil;
}

- (IBAction)oneButtonPressed:(id)sender {
    NSString *appendString = [NSString stringWithFormat:@"%@%@",inputTextField.text,@"1"];
    [inputTextField setText:appendString];
}
- (IBAction)twoButtonPressed:(id)sender {
    NSString *appendString = [NSString stringWithFormat:@"%@%@",inputTextField.text,@"2"];
    [inputTextField setText:appendString];
}
- (IBAction)threeButtonPressed:(id)sender {
    NSString *appendString = [NSString stringWithFormat:@"%@%@",inputTextField.text,@"3"];
    [inputTextField setText:appendString];
}
- (IBAction)fourButtonPressed:(id)sender {
    NSString *appendString = [NSString stringWithFormat:@"%@%@",inputTextField.text,@"4"];
    [inputTextField setText:appendString];
}
- (IBAction)fiveButtonPressed:(id)sender {
    NSString *appendString = [NSString stringWithFormat:@"%@%@",inputTextField.text,@"5"];
    [inputTextField setText:appendString];
}
- (IBAction)sixButtonPressed:(id)sender {
    NSString *appendString = [NSString stringWithFormat:@"%@%@",inputTextField.text,@"6"];
    [inputTextField setText:appendString];
}
- (IBAction)sevenButtonPressed:(id)sender {
    NSString *appendString = [NSString stringWithFormat:@"%@%@",inputTextField.text,@"7"];
    [inputTextField setText:appendString];
}
- (IBAction)eightButtonPressed:(id)sender {
    NSString *appendString = [NSString stringWithFormat:@"%@%@",inputTextField.text,@"8"];
    [inputTextField setText:appendString];
}
- (IBAction)nineButtonPressed:(id)sender {
    NSString *appendString = [NSString stringWithFormat:@"%@%@",inputTextField.text,@"9"];
    [inputTextField setText:appendString];
}
- (IBAction)cancelButtonPressed:(id)sender {
    [inputTextField setText:@""];
    [inputTextField setPlaceholder:@"Enter your staff ID number"];
    staffID = nil;
    staffPIN = nil;
}

- (IBAction)zeroButtonPressed:(id)sender {
    NSString *appendString = [NSString stringWithFormat:@"%@%@",inputTextField.text,@"0"];
    [inputTextField setText:appendString];
}

- (IBAction)enterButtonPressed:(id)sender {
    if (![inputTextField.text isEqual: @""]){
        if (!staffID){
            staffID = inputTextField.text;
            [inputTextField setText:@""];
            [inputTextField setPlaceholder:@"Enter your staff PIN"];
        }
        else {
            staffPIN = inputTextField.text;
            NSString *parsedStaffURL = [NSString stringWithFormat:@"%@%@%@", @"https://clockinoutapp.appspot.com/_je/", accountUUID, @"-team"];
            NSURL *teamURL = [NSURL URLWithString: parsedStaffURL];
            NSMutableURLRequest *staffRequest = [NSMutableURLRequest requestWithURL:teamURL
                                                                   cachePolicy:NSURLRequestReloadIgnoringLocalCacheData
                                                               timeoutInterval:60];
            checkStaffConnection = [[NSURLConnection alloc] initWithRequest:staffRequest delegate:self];
        }
    }
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response {
    if (connection == checkStaffConnection) staffResponseData = [[NSMutableData alloc] init];
    if (connection == accountDetailsConnection) accountResponseData = [[NSMutableData alloc] init];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data {
    if (connection == checkStaffConnection) [staffResponseData appendData:data];
    if (connection == accountDetailsConnection) [accountResponseData appendData:data];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error {
    NSLog(@"Unable to fetch data");
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection
{
    if (connection == checkStaffConnection) {
    NSLog(@"Succeeded! Received %d bytes of data",[staffResponseData
                                                   length]);
    NSString *txt = [[NSString alloc] initWithData:staffResponseData encoding: NSASCIIStringEncoding];
    NSLog(txt);
    jsonParser = [[SBJsonParser alloc] init];
    NSError *error = nil;
    NSArray *jsonObjects = [jsonParser objectWithString:txt];
    StaffMember *staffMember = [[StaffMember alloc]init];
    NSLog(@"%@", staffID);
    NSLog(@"%@", staffPIN);
    for (int i = 0; i < jsonObjects.count; i++){
        NSMutableDictionary *dictionary = [jsonObjects objectAtIndex:i];
        if ([[dictionary objectForKey:@"UserID"] isEqual: staffID] && [[dictionary objectForKey:@"PIN"] isEqual: staffPIN]){
            NSLog(@"Works");
            staffMember.staffID = [dictionary objectForKey:@"UserID"];
            staffMember.staffPIN = [dictionary objectForKey:@"PIN"];
            staffMember.staffName = [dictionary objectForKey:@"Name"];
            AppDelegate *appDelegate = (AppDelegate *)[[UIApplication sharedApplication] delegate];
            appDelegate.window = [[UIWindow alloc] initWithFrame:[[UIScreen mainScreen] bounds]];
            // Override point for customization after application launch.
            PhotoViewController *photoViewController = [[PhotoViewController alloc] initWithNibName:@"PhotoViewController" bundle:nil];
            photoViewController.accountUUID = accountUUID;
            photoViewController.staffMember = staffMember;
            appDelegate.window.rootViewController = photoViewController;
            [appDelegate.window makeKeyAndVisible];
        }
    }

    }
    if (connection == accountDetailsConnection){
        NSLog(@"Succeeded! Received %d bytes of data",[accountResponseData
                                                       length]);
        NSString *txt = [[NSString alloc] initWithData:accountResponseData encoding: NSASCIIStringEncoding];
        NSLog(txt);
        SBJsonParser *jsonParser = [[SBJsonParser alloc] init];
        NSError *error = nil;
        [jsonParser objectWithString:txt];
        NSArray *jsonObjects = [jsonParser objectWithString:txt];

        for (int i = 0; i < jsonObjects.count; i++){
            NSMutableDictionary *dictionary = [jsonObjects objectAtIndex:i];
            NSLog(@"%@", [dictionary objectForKey:@"Greeting"]);
            [headerLabel setText:[dictionary objectForKey:@"Greeting"]];
        }
    }
}

@end
