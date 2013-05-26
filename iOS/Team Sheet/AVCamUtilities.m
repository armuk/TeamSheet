//
//  AVCamUtilities.m
//  Team Sheet
//
//  Created by James Guthrie on 18/02/2013.
//  Copyright (c) 2013 Hey Jimmy. All rights reserved.
//

#import "AVCamUtilities.h"
#import <AVFoundation/AVFoundation.h>

@implementation AVCamUtilities

+ (AVCaptureConnection *)connectionWithMediaType:(NSString *)mediaType fromConnections:(NSArray *)connections
{
    for ( AVCaptureConnection *connection in connections ) {
        for ( AVCaptureInputPort *port in [connection inputPorts] ) {
            if ( [[port mediaType] isEqual:mediaType] ) {
                return connection;
            }
        }
    }
    return nil;
}

@end