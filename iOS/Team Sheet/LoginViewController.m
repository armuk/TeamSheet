//
//  ViewController.m
//  Team Sheet
//
//  Created by James Guthrie on 29/01/2013.
//  Copyright (c) 2013 Hey Jimmy. All rights reserved.
//

#import "LoginViewController.h"
#import "SigninViewController.h"
#include <CommonCrypto/CommonDigest.h>

@interface LoginViewController ()

@end

@implementation LoginViewController

@synthesize emailTextField, passwordTextField, loginButton, loginButtonImage;

- (void)viewDidLoad
{
    [super viewDidLoad];
    [loginButton setBackgroundImage:loginButtonImage.image forState:UIControlStateNormal];
}
- (IBAction)loginButtonPressed:(id)sender {
    [self login];
}

- (void) login {
    NSMutableURLRequest *request =
    [[NSMutableURLRequest alloc] initWithURL:
     [NSURL URLWithString:@"http://heyjimmy.net/mobilesignin/index.php"]];
    
    [request setHTTPMethod:@"POST"];
    
    NSString *postString = [NSString stringWithFormat:@"email=%@&password=%@",emailTextField.text,[LoginViewController createSHA512:passwordTextField.text]];
    
    [request setValue:[NSString
                       stringWithFormat:@"%d", [postString length]]
   forHTTPHeaderField:@"Content-length"];
    
    [request setHTTPBody:[postString
                          dataUsingEncoding:NSUTF8StringEncoding]];
    
    [[NSURLConnection alloc] initWithRequest:request delegate:self];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

- (BOOL)textFieldShouldReturn:(UITextField *)textField {
    if ([emailTextField isFirstResponder]){
    [passwordTextField becomeFirstResponder];
    return YES;
    }
if ([passwordTextField isFirstResponder]){
    [passwordTextField resignFirstResponder];
    [self login];
    return YES;
}
}

+ (NSString *) createSHA512:(NSString *)source {
    
    const char *s = [source cStringUsingEncoding:NSASCIIStringEncoding];
    
    NSData *keyData = [NSData dataWithBytes:s length:strlen(s)];
    
    uint8_t digest[CC_SHA512_DIGEST_LENGTH] = {0};
    
    CC_SHA512(keyData.bytes, keyData.length, digest);
    
    NSData *out = [NSData dataWithBytes:digest length:CC_SHA512_DIGEST_LENGTH];
    NSString *hash = [out description];
    hash = [hash stringByReplacingOccurrencesOfString:@" " withString:@""];
    hash = [hash stringByReplacingOccurrencesOfString:@"<" withString:@""];
    hash = [hash stringByReplacingOccurrencesOfString:@">" withString:@""];
    NSLog(@"%@", hash);
    return hash;
}

- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response {
    responseData = [[NSMutableData alloc] init];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data {
    [responseData appendData:data];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error {
    NSLog(@"Unable to fetch data");
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection
{
    NSLog(@"Succeeded! Received %d bytes of data",[responseData
                                                   length]);
    NSString *txt = [[NSString alloc] initWithData:responseData encoding: NSUTF8StringEncoding    ];
    NSLog(@"Response is %@", txt);
    
    if ([txt rangeOfString:@"Expired"].location != NSNotFound){
        UIAlertView *expiredAlert = [[UIAlertView alloc]initWithTitle:@"Expired" message:@"Your subscription has expired, please re-subscribe" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil, nil];
        [expiredAlert show];    }
    else if ([txt rangeOfString:@"Inactive"].location != NSNotFound){
        UIAlertView *inactiveAlert = [[UIAlertView alloc]initWithTitle:@"Inactive" message:@"Your account is inactive, please check your emails" delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil, nil];
        [inactiveAlert show];
    }
    else if (txt.length == 36)
    {
        AppDelegate *appDelegate = (AppDelegate *)[[UIApplication sharedApplication] delegate];
        appDelegate.window = [[UIWindow alloc] initWithFrame:[[UIScreen mainScreen] bounds]];
        // Override point for customization after application launch.
        SigninViewController *signinViewController = [[SigninViewController alloc] initWithNibName:@"SigninViewController" bundle:nil];
        signinViewController.accountUUID = txt;
        appDelegate.window.rootViewController = signinViewController;
        [appDelegate.window makeKeyAndVisible];
    }
}

@end
