import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { InstructorfollowersComponent } from './instructorfollowers.component';

describe('InstructorfollowersComponent', () => {
  let component: InstructorfollowersComponent;
  let fixture: ComponentFixture<InstructorfollowersComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ InstructorfollowersComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(InstructorfollowersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
