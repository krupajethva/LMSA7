import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { InstructorfollowingsComponent } from './instructorfollowings.component';

describe('InstructorfollowingsComponent', () => {
  let component: InstructorfollowingsComponent;
  let fixture: ComponentFixture<InstructorfollowingsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ InstructorfollowingsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(InstructorfollowingsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
