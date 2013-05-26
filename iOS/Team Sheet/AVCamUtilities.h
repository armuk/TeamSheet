//
//  AVCamUtilities.h
//  Team Sheet
//
//  Created by James Guthrie on 18/02/2013.
//  Copyright (c) 2013 Hey Jimmy. All rights reserved.
//

#import <Foundation/Foundation.h>

@class AVCaptureConnection;

@interface AVCamUtilities : NSObject {
    
}

+ (AVCaptureConnection *)connectionWithMediaType:(NSString *)mediaType fromConnections:(NSArray *)connections;

@end