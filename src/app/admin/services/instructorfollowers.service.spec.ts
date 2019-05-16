import { TestBed, inject } from '@angular/core/testing';

import { InstructorfollowersService } from './instructorfollowers.service';

describe('InstructorfollowersService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [InstructorfollowersService]
    });
  });

  it('should be created', inject([InstructorfollowersService], (service: InstructorfollowersService) => {
    expect(service).toBeTruthy();
  }));
});
